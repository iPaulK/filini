<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;
use Core\Entity\Category;

class IndexController extends CoreController
{
    public function indexAction()
    {
        $query = $this->getRepository('Category')->findByStatus(Category::STATUS_ENABLED);
        $categories = $query->getResult();
        return new ViewModel([
            'categories' => $categories,
        ]);
    }
}
