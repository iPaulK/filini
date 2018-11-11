<?php

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;
use \Core\Entity\Category;

class CatalogController extends CoreController
{
    public function indexAction(): ViewModel
    {
        $slug = $this->params()->fromRoute('slug', false);
        $curentCategory = $this->getRepository(Category::class)->findOneBySlug($slug);

        return new ViewModel([
            'curentCategory' => $curentCategory,
            'categories' => $this->getActiveCategories(),
        ]);
    }
}
