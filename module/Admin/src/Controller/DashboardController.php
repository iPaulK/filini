<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;
use Core\Entity\Product;
use Core\Entity\Product\{
    Sofa, Chair, Stool, Bed
};

class DashboardController extends CoreController
{
    public function indexAction(): ViewModel
    {
        $productsCounter = [
            Product::TYPE_SOFA => $this->getRepository(Product::class)->getCountByDiscr(Sofa::class),
            Product::TYPE_CHAIR => $this->getRepository(Product::class)->getCountByDiscr(Chair::class),
            Product::TYPE_STOOL => $this->getRepository(Product::class)->getCountByDiscr(Stool::class),
            Product::TYPE_BED => $this->getRepository(Product::class)->getCountByDiscr(Bed::class),
        ];

        return new ViewModel([
            'productsCounter' => $productsCounter,
        ]);
    }
}
