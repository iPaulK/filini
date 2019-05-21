<?php


namespace Admin\Controller;


use Core\Controller\CoreController;
use Core\Entity\VideoReview;
use Doctrine\ORM\OptimisticLockException;
use Zend\Form\Form;
use Zend\Http\Response;
use Zend\View\Model\ViewModel;

class VideoReviewController extends CoreController
{
    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);
        $limit = $this->params()->fromQuery('limit', 10);

        $query = $this->getRepository(VideoReview::class)->findVideoReviews();

        $paginator = $this->getPaginatorByQuery($query, $page, $limit);

        return new ViewModel([
            'paginator' => $paginator
        ]);
    }

    public function editAction()
    {
        /** @var VideoReview $videoReview */
        $videoReview = $this->getEntity(VideoReview::class, $this->params()->fromRoute('id'));

        if (!$videoReview) {
            $videoReview = new VideoReview();
        }

        $form = $this->createVideoReviewForm($videoReview);
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getEm()->persist($videoReview);
                $this->getEm()->flush();
                return $this->redirect()->toRoute('admin_video_review');
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }

    /**
     * Remove video review action
     *
     * @return Response
     * @throws OptimisticLockException
     */
    public function removeAction()
    {
        $videoReview = $this->getEntity(VideoReview::class, $this->params()->fromRoute('id'));

        if ($videoReview) {
            $this->getEm()->remove($videoReview);
            $this->getEm()->flush();
        }

        return $this->redirect()->toRoute('admin_video_review');
    }

    /**
     * @param VideoReview $videoReview
     * @return Form
     */
    protected function createVideoReviewForm($videoReview)
    {
        $form = $this->createForm($videoReview);
        $form->setAttributes([
            'action' => $this->url()->fromRoute('admin_video_review', ['action' => 'edit', 'id' => $videoReview->getId()]),
        ]);

        return $form;
    }
}