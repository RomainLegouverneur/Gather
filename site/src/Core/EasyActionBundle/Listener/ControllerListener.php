<?php

namespace Core\EasyActionBundle\Listener;

use Core\EasyActionBundle\Controller\EasyActionController;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerListener
{

    public function onKernelController(FilterControllerEvent $event)
    {
        $pair = $event->getController();

        if ($pair[0] instanceof EasyActionController)
        {
            $controller = $pair[0];
            $method = $pair[1];
            $controller->setAction($method);
            $pair = array($controller, 'actionCaller');
        }
        
        $event->setController($pair);
    }
}
?>
