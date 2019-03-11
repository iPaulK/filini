<?php

namespace Application;


use Zend\Mail\Transport\Sendmail;
use Zend\View\Model\ViewModel;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;
use Zend\Mime\Part as MimePart;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;


class Mail
{
    CONST CONTACT_EMAIL = 'filini.minsk@gmail.com';

    protected $_view;

    public function __construct()
    {
        $view = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap([
            'proposal' => __DIR__ . '/../../../view/application/mail/proposal.phtml'
        ]);

        $view->setResolver($resolver);
        $this->_view = $view;
    }

    public function sendProposal($phone, $name)
    {
        $viewModel = new ViewModel();
        $viewModel
            ->setTemplate('proposal')
            ->setVariables([
                'phone' => $phone,
                'name' => $name
            ]);

        $content = $this->_view->render($viewModel);

        $html = new MimePart($content);
        $html->type = 'text/html';
        $html->charset = 'UTF-8';

        $text = new MimePart('');
        $text->type = 'text/plain';

        $body = new MimeMessage();
        $body->setParts(array($text, $html));

        $message = new Message();
        $message->setFrom('info@filini.by', 'Info filini');
        $message->addTo('filini.minsk@gmail.com');
        $message->setSubject('Новая заявка на звонок');

        $message->setEncoding('UTF-8');
        $message->setBody($body);
        $message->getHeaders()->get('content-type')->setType('multipart/alternative');

        $transport = new Sendmail();
        $transport->send($message);
    }
}