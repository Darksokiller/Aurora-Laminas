<?php
namespace Application\Controller;
use Laminas\Mvc\Controller\AbstractActionController;
//namespace Laminas\Mvc\Controller;

use Laminas\Mvc\Exception;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

class AbstractController extends AbstractActionController
{
    public $baseUrl;
    public function onDispatch(MvcEvent $e) {
        $this->baseUrl = $this->getRequest()->getBasePath();
        //die('running');
        //var_dump($this);
        $serviceManager = $e->getApplication()->getServiceManager();
        var_dump($serviceManager);
       // $session = $serviceManager->get()
        $this->_init();
        return parent::onDispatch($e);
    }
    public function _init()
    {
       // var_dump($_SESSION);
    }
    
//     public function setEventManager(EventManagerInterface $events)
//     {
//         parent::setEventManager($events);
        
//         $events->attach('dispatch', function ($e) {
//             $controllerClass = $e->getRouteMatch()->getParam('controller', 'index');
//             $e->getViewModel()->setVariable('controller', $controllerClass);
//         }, 100);
            
//     }
}
