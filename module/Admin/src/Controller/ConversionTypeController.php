<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\ConversionType;
use Core\Entity\Image;
use Zend\View\Model\{
    ViewModel, JsonModel
};

class ConversionTypeController extends CoreController
{
    /**
     * Show list of schemas
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(ConversionType::class)->findConversionTypes();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * Edit conversion type action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\ConversionType $conversionType */
        $conversionType = $this->getEntity(
            ConversionType::class,
            $this->params()->fromRoute('id')
        );
        if (!$conversionType) {
            $conversionType = new ConversionType();
        }

        $form = $this->createConversionTypeForm($conversionType);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            $thumbnail = $form->get('thumbnail')->getValue();
            if (is_numeric($thumbnail)) {
                $image = $this->getRepository(Image::class)->findOneBy(['id' => $thumbnail]);
                $form->get('thumbnail')->setValue($image);
            }
            
            if ($form->isValid()) {
                $this->getEm()->persist($conversionType);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_product_conversion');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove conversion type action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $conversionType = $this->getEntity(ConversionType::class, $this->params()->fromRoute('id'));
        if ($conversionType) {
            $this->getEm()->remove($conversionType);
            $this->getEm()->flush();
        }
        
        return $this->redirect()->toRoute('admin_product_conversion');
    }

    /**
     * Upload thumbnail
     *
     * @return JsonModel
     */
    public function uploadThumbnailAction(): JsonModel
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $thumbnail = $request->getFiles()->get('files')[0];
            $preset = 'category';

            //upload file to the server and create File entity
            if (!isset($thumbnail)) {
                return new JsonModel([
                    'success' => false,
                    'message' => $this->translate('The file was not uploaded'),
                ]);
            }

            // Upload file
            $uploadResult = $this->uploader()->upload($thumbnail, $preset);
            if (!$uploadResult['success']) {
                return new JsonModel([
                    'success' => false,
                    'message' => $uploadResult['message'],
                ]);
            }

            /** @var Core\Entity\File */
            $file = $uploadResult['file'];

            /** @var Core\Entity\Image */
            $image = $this->uploader()->generateImageEntity($file, $preset); // Generate Image Entity
            $this->uploader()->generateImagePresets($image, $preset); // Generate presests
            
            $data['files'][] = [
                'imageId' => $image->getId(),
                'name' =>  $file->getName(),
                'url' =>  $file->getRelativeUrl(),
                'thumbnailUrl' => $file->getRelativeUrl('preview'),
                'size' => $file->getSize(),
                'deleteUrl' => $this->url()->fromRoute('admin_product_conversion', ['action' => 'delete-thumbnail', 'id' => $image->getId()]),
                'deleteType' => 'DELETE',
            ];
            
            return new JsonModel($data);
        }
    }

    /**
     * Delete thumbnail
     *
     * @return JsonModel
     */
    public function deleteThumbnailAction(): JsonModel
    {
        $image = $this->getEntity(Image::class, $this->params()->fromRoute('id'));
        if ($image) {
            $this->getEm()->remove($image);
            $this->getEm()->flush();
        }
        return new JsonModel(['data' => 'deleted']);
    }

    /**
     * @param \Core\Entity\ConversionType $conversionType
     * @return \Zend\Form\Form
     */
    protected function createConversionTypeForm($conversionType)
    {
        $form = $this->createForm($conversionType);
        $form->setAttributes([
            'action' => $this->url()->fromRoute(
                'admin_product_conversion',
                ['action' => 'edit', 'id' => $conversionType->getId()]
            ),
        ]);
        return $form;
    }
}
