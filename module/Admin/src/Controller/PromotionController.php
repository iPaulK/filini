<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Promotion;
use Core\Entity\Image;
use Zend\View\Model\{
    ViewModel, JsonModel
};

class PromotionController extends CoreController
{
    /**
     * Show list of promotions
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(Promotion::class)->findPromotions();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);

        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    public function editAction()
    {
        /** @var \Core\Entity\Promotion $promotion */
        $promotion = $this->getEntity(Promotion::class, $this->params()->fromRoute('id'));

        if (!$promotion) {
            $promotion = new Promotion();
        }

        $form = $this->createPromotionForm($promotion);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            $promotionImage = $form->get('promotionImage')->getValue();
            if (is_numeric($promotionImage)) {
                $image = $this->getRepository(Image::class)->findOneBy(['id' => $promotionImage]);
                $form->get('promotionImage')->setValue($image);
            }

            if ($form->isValid()) {
                $this->getEm()->persist($promotion);
                $this->getEm()->flush();

                return $this->redirect()->toRoute('admin_promotions');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove promotion action
     *
     * @return \Zend\Http\Response
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeAction()
    {
        $promotion = $this->getEntity(Promotion::class, $this->params()->fromRoute('id'));

        if ($promotion) {
            $this->getEm()->remove($promotion);
            $this->getEm()->flush();
        }

        return $this->redirect()->toRoute('admin_promotions');
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
            $preset = 'promotion';

            //upload file to the server and create File entity
            if (!isset($thumbnail)) {
                return new JsonModel([
                    'success' => false,
                    'message' => $this->translate("The file was not uploaded"),
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
                'deleteUrl' => $this->url()->fromRoute('admin_promotions', ['action' => 'delete-thumbnail', 'id' => $image->getId()]),
                'deleteType' => 'DELETE',
            ];
            return new JsonModel($data);
        }
    }

    /**
     * Delete thumbnail
     *
     * @return JsonModel
     * @throws \Doctrine\ORM\OptimisticLockException
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
     * @param \Core\Entity\Promotion $promotion
     * @return \Zend\Form\Form
     */
    protected function createPromotionForm($promotion)
    {
        $form = $this->createForm($promotion);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_promotions', ['action' => 'edit', 'id' => $promotion->getId()]),
        ]);

        return $form;
    }
}
