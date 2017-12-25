<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Core\Entity\Product;
use Core\Entity\Product\{
    Sofa, Chair, Stool, Bed
};
use Zend\View\Model\{
    ViewModel, JsonModel
};

class ProductController extends CoreController
{
    /**
     * Show list of products
     *
     * @return ViewModel
     */
    public function indexAction(): ViewModel
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $productsCounter = [
            Product::TYPE_SOFA => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Sofa'),
            Product::TYPE_CHAIR => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Chair'),
            Product::TYPE_STOOL => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Stool'),
            Product::TYPE_BED => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Bed'),
        ];

        $query = $this->getRepository('Product')->findProducts();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);
        return new ViewModel([
            'paginator' => $paginator,
            'productsCounter' => $productsCounter,
        ]);
    }

    /**
     * Edit product action
     *
     * @return ViewModel
     */
    public function editAction(): ViewModel
    {
        /** @var \Core\Entity\Product $product */
        $product = $this->getEntity('Product', $this->params()->fromRoute('id'));
        if (!$product) {
            $product = $this->initProduct();
        }

        $form = $this->createProductForm($product);

        $request = $this->getRequest();
        if ($request->isPost()) {
        	$data = $request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                /**
                 * Initialize product images
                 */
                $product->getImages()->clear();
                if(!empty($data['images'])){
                    foreach($data['images'] as $image_id){
                        $image = $this->getEntity('Image', $image_id);
                        if ($image) {
                            $product->addImage($image);
                        }
                    }
                }

                $this->getEm()->persist($product);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_product');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove product action
     *
     * @return ViewModel
     */
    public function removeAction(): ViewModel
    {
        $product = $this->getEntity('Product', $this->params()->fromRoute('id'));
        if ($product) {
            $this->getEm()->remove($product);
            $this->getEm()->flush();
        }
        return $this->redirect()->toRoute('admin_product');
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
            $preset = 'product';

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
                'deleteUrl' => $this->url()->fromRoute('admin_product_category', ['action' => 'delete-image', 'id' => $image->getId()]),
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
        $image = $this->getEntity('Image', $this->params()->fromRoute('id'));
        if ($image) {
            $this->getEm()->remove($image);
            $this->getEm()->flush();
        }
        return new JsonModel(['data' => 'deleted']);
    }

    /**
     * Init product
     *
     * @param string $defaultType
     * @return Core\Entity\Product
     */
    protected function initProduct($defaultType = Product::TYPE_SOFA)
    {
        $type = $this->params()->fromQuery('type', $defaultType);
        switch ($type) {
            case Product::TYPE_SOFA:
                $product = new Sofa();
                break;
            case Product::TYPE_CHAIR:
                $product = new Chair();
                break;
            case Product::TYPE_STOOL:
                $product = new Stool();
                break;
            case Product::TYPE_BED:
                $product = new Bed();
                break;
            default:
                $product = new Sofa();
                break;
        }

        return $product;
    }

    /**
     * @param \Core\Entity\Product $product
     * @param string $defaultType
     * @return \Zend\Form\Form
     */
    protected function createProductForm($product, $defaultType=Product::TYPE_SOFA)
    {
        $type = $this->params()->fromQuery('type', $defaultType);

        $form = $this->createForm($product);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_product', [
                'action' => 'edit',
                'id' => $product->getId()
            ], [
                'query' => [
                    'type' => $type
                ]
            ]),
        ]);
        return $form;
    }
}
