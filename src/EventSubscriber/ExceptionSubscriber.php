<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var \mailer
     */
    private $mailer;

    
    private $from;

    private $to;

    public function __construct(\Swift_Mailer $mailer)
    {
       $this->mailer = $mailer; 
    }
    public static function getSubscribedEvents()
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event)
    {
        $message = (new \Swift_Message())
                    ->setFrom($this->from)
                    ->setTo($this->to)
                    ->setBody("{$event->getRequest()->getRequestUri()}
                    
                    {$event->getException()->getMessage()}

                    {$event->getException()->getTraceAsString()}

                    ");
        $this->mailer->send($message);
    }
}
