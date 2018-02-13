<?php

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;
use Core\Entity\Product;

class ProductController extends CoreController
{
    public function viewAction()
    {
        $slug = $this->params()->fromRoute('slug', false);
        $product = $this->getRepository(Product::class)->findOneBySlug($slug);
        if (!$product) {
            // Error condition - product not found
            $this->getResponse()->setStatusCode(404);
            return;
        }
        return new ViewModel([
            'product' => $product,
        ]);
    }
}
