<?php

namespace Core\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceManager;
use Doctrine\ORM\EntityManager;
use PHPImageWorkshop\ImageWorkshop;
use Core\Entity\{File, Image};
use Core\Traits\DoctrineBasicsTrait;

class UploadFilePlugin extends AbstractPlugin
{
    use DoctrineBasicsTrait;

    /**
     * @var Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    public function __construct(EntityManager $entityManager, ServiceManager $serviceManager) 
    {
        $this->entityManager = $entityManager;
        $this->serviceManager = $serviceManager;
    }

    /**
     * @return array
     */
    public function upload($fileParams, $uploadType = null)
    {
        $uploadFileParams['path'] = '/uploads/files/';
        if ($uploadType) {
            $uploadFileParams = $this->getUploadFileParams($uploadType);
        }

        $serverPath = explode('./public', $uploadFileParams['path']);
        $serverPath = count($serverPath) > 1 ? $serverPath[1] : $serverPath[0];
        $file = new File();
        $file
            ->setName($fileParams['name'])
            ->setPath($serverPath)
            ->setSize($fileParams['size'])
            ->setType($fileParams['type']);
        $this->getEm()->persist($file);
        $this->getEm()->flush();
        
        if (!is_dir($file->getMainPath())) {
            if (!mkdir($file->getMainPath(), 0777, true) || !chmod($file->getMainPath(), 0777)) {
                return [
                    'success' => false,
                    'message' => 'Directory creation error.',
                ];
            }
        }

        if (copy($fileParams['tmp_name'], $file->getAllPath())) {
			unlink($fileParams['tmp_name']);
		}
        $this->changePublicPathMode($file->getAllPath());
        return [
            'success' => true,
            'file' => $file,
        ];
    }

    /**
     * @param \Core\Entity\File $file
     * @return \Core\Entity\Image
     */
    public function generateImageEntity($file, $type = null)
    {
        $layer = ImageWorkshop::initFromPath($file->getAllPath());
        $image = new Image();
        $image
            ->setFile($file)
            ->setWidth($layer->getWidth())
            ->setHeight($layer->getHeight());
        if ($type) {
            $image->setImageType($type);
        }
        $this->getEm()->persist($image);
        $this->getEm()->flush();
        return $image;
    }

    /**
     * @param \Core\Entity\Image $image
     * @param string $uploadType
     * @param string $preset
     */
    public function generateImagePresets($image, $uploadType)
    {
        $uploadFileParams = $this->getUploadFileParams($uploadType);
        $presets = $uploadFileParams['presets'];
        foreach ($presets as $preset => $v) {
            $dimensions = $uploadFileParams['presets'][$preset];
            $layer = ImageWorkshop::initFromPath($image->getFile()->getAllPath());
            $layer->resizeInPixel($dimensions['x'], $dimensions['y'], true);
            $resizedFileName = $preset;
            if ($ext = pathinfo($image->getFile()->getMainName(), PATHINFO_EXTENSION)) {
                $resizedFileName .= '.' . $ext;
            }
            $layer->save($image->getFile()->getMainPath(), $resizedFileName, true, null, 100);
            @chmod($image->getFile()->getMainPath() . $resizedFileName, 0777);
        }
    }

    /**
     * @return void
     */
    protected function changePublicPathMode($path)
    {
        $publicPath = 'public';
        $paths = explode($publicPath . '/', $path);
        $pathLevels = explode('/', $paths[1]);
        foreach ($pathLevels as $pathLevel) {
            $publicPath .= '/' . $pathLevel;
            @chmod($publicPath, 0777);
        }
    }

    /**
     * @param string $preset
     * @return array
     */
    protected function getUploadFileParams($preset)
    {
        return $this->serviceManager->get('Config')['uploads'][$preset];
    }
}