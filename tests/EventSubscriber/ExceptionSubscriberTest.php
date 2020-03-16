<?php

namespace App\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use App\EventSubscriber\ExceptionSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ExceptionSubscriberTest extends TestCase 
{
    public function testEventSubscription()
    {
        $this->assertArrayHasKey(ExceptionEvent::class,ExceptionSubscriber::getSubscribedEvents());
    }

    public function testOnSendExceptionSendEmail()
    {
        $mailer =  $this->getMockBuilder(\Swift_Mailer::class)
        ->disableOriginalConstructor()
        ->getMock();
        $mailer->expects($this->once())->method('send');
        $this->dispatch($mailer);

    }

    public function testonExeptionSendEmailToTheAdmin()
    {
        $mailer =  $this->getMockBuilder(\Swift_Mailer::class)
        ->disableOriginalConstructor()
        ->getMock();
        $mailer->expects($this->once())
        ->method('send')
        ->with($this->callback(function (\Swift_Message $message) {
            return  array_key_exists('from@gmail.com',$message->getFrom()) &&
                    array_key_exists('to@gmail.com',$message->getTo());

        }));
        $this->dispatch($mailer);
    }
    public function testonExeptionSendEmailToTheTrace()
    {
        $mailer =  $this->getMockBuilder(\Swift_Mailer::class)
        ->disableOriginalConstructor()
        ->getMock();
        $mailer->expects($this->once())
        ->method('send')
        ->with($this->callback(function (\Swift_Message $message) {
            return  strpos($message->getBody(),'ExceptionSubscriberTest') && 
            strpos($message->getBody(),'Hello World')
            ;

        }));
        $this->dispatch($mailer);
    }

    private function dispatch($mailer)
    {
             
        $subscriber = new ExceptionSubscriber($mailer,'from@gmail.com','to@gmail.com');
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        $event = new ExceptionEvent($kernel, new Request(),1,new \Exception('Hello World')); 
        $dispatcher =  new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);
    }
}