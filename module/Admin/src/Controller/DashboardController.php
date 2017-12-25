<?php

namespace Admin\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;
use Core\Entity\Product;

class DashboardController extends CoreController
{
    public function indexAction(): ViewModel
    {
        $productsCounter = [
            Product::TYPE_SOFA => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Sofa'),
            Product::TYPE_CHAIR => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Chair'),
            Product::TYPE_STOOL => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Stool'),
            Product::TYPE_BED => $this->getRepository('Product')->getCountByDiscr('\Core\Entity\Product\Bed'),
        ];

        return new ViewModel([
            'productsCounter' => $productsCounter,
        ]);
    }
}
