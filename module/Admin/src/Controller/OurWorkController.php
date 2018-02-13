<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\OurWork;
use Core\Entity\Image;
use Zend\View\Model\{
    ViewModel, JsonModel
};
use Doctrine\Common\Collections\ArrayCollection;

class OurWorkController extends CoreController
{
    /**
     * Show list of works
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(OurWork::class)->findOurWorks();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * Edit work action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\OurWork $work */
        $work = $this->getEntity(OurWork::class, $this->params()->fromRoute('id'));
        if (!$work) {
            $work = new OurWork();
        }

        $form = $this->createOurWorkForm($work);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $form->setData($data);

            /**
             * Initialize product images
             */
            $work->getImages()->clear();
            if(!empty($data['images'])){
                foreach($data['images'] as $image_id){
                    $image = $this->getEntity(Image::class, $image_id);
                    if ($image) {
                        $work->addImage($image);
                    }
                }
            }
            
            if ($form->isValid()) {
                $this->getEm()->persist($work);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_work');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove work action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $work = $this->getEntity(OurWork::class, $this->params()->fromRoute('id'));
        if ($work) {
            $this->getEm()->remove($work);
            $this->getEm()->flush();
        }
        return $this->redirect()->toRoute('admin_work');
    }

    /**
     * Upload image
     *
     * @return JsonModel
     */
    public function uploadImageAction(): JsonModel
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $image = $request->getFiles()->get('files')[0];
            $preset = 'our-work';

            //upload file to the server and create File entity
            if (!isset($image)) {
                return new JsonModel([
                    'success' => false,
                    'message' => $this->translate("The file was not uploaded"),
                ]);
            }

            // Upload file
            $uploadResult = $this->uploader()->upload($image, $preset);
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
                'deleteUrl' => $this->url()->fromRoute('admin_work', ['action' => 'delete-image', 'id' => $image->getId()]),
                'deleteType' => 'DELETE',
            ];
            return new JsonModel($data);
        }
    }

    /**
     * Delete image
     *
     * @return JsonModel
     */
    public function deleteImageAction(): JsonModel
    {
        $image = $this->getEntity(Image::class, $this->params()->fromRoute('id'));
        if ($image) {
            $this->getEm()->remove($image);
            $this->getEm()->flush();
        }
        return new JsonModel(['data' => 'deleted']);
    }

    /**
     * @param \Core\Entity\OurWork $work
     * @return \Zend\Form\Form
     */
    protected function createOurWorkForm($work)
    {
        $form = $this->createForm($work);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_work', ['action' => 'edit', 'id' => $work->getId()]),
        ]);
        return $form;
    }
}
