<?php

namespace Shokai\Event\EventSubscriber;

use Shokai\Application;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class  AuthEventSubscriber implements EventSubscriberInterface{

    /** @var Application */
    protected $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }
    
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => [
                ['onKernelController', 0]
            ]
        ];
    }
    
    public function onKernelController(FilterControllerEvent $event) {
        
        $controller = $event->getController();
              
        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof LoginAuthenticatedController) {
            $this->app['monolog']->error("is instance");
            $c = $controller[0];
            if(!$this->app->isLoggedin()) {
                return $c->redirectLogin();
            }
        }
    }    
}
