<?php
namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Category;
use Zend\View\Model\{
    ViewModel, JsonModel
};
use Doctrine\Common\Collections\ArrayCollection;

class CategoryController extends CoreController
{
    /**
     * Show list of categories
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository('Category')->findCategories();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    /**
     * Edit category action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\Category $category */
        $category = $this->getEntity('Category', $this->params()->fromRoute('id'));
        if (!$category) {
            $category = new Category();
        }

        $form = $this->createCategoryForm($category);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            $thumbnail = $form->get('thumbnail')->getValue();
            if (is_numeric($thumbnail)) {
                $image = $this->getRepository('Image')->findOneBy(['id' => $thumbnail]);
                $form->get('thumbnail')->setValue($image);
            }
            
            if ($form->isValid()) {
                $this->getEm()->persist($category);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_product_category');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove category action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $category = $this->getEntity('Category', $this->params()->fromRoute('id'));
        if ($category) {
            $this->getEm()->remove($category);
            $this->getEm()->flush();
        }
        return $this->redirect()->toRoute('admin_product_category');
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
                'deleteUrl' => $this->url()->fromRoute('admin_product_category', ['action' => 'delete-thumbnail', 'id' => $image->getId()]),
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
        $image = $this->getEntity('Image', $this->params()->fromRoute('id'));
        if ($image) {
            $this->getEm()->remove($image);
            $this->getEm()->flush();
        }
        return new JsonModel(['data' => 'deleted']);
    }

    /**
     * @param \Core\Entity\Category $category
     * @return \Zend\Form\Form
     */
    protected function createCategoryForm($category)
    {
        $form = $this->createForm($category);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_product_category', ['action' => 'edit', 'id' => $category->getId()]),
        ]);
        return $form;
    }
}
