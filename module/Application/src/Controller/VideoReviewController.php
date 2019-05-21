<?php


namespace Application\Controller;

use Core\Controller\CoreController;
use Zend\View\Model\ViewModel;

class VideoReviewController extends CoreController
{
    public function indexAction(): ViewModel
    {
        return new ViewModel([
            'categories' => $this->getActiveCategories(),
            'videoReviews' => $this->getVideoReviews()
        ]);
    }
}