<?php
namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService as AuthService;
use User\Model\UserTable as Table;
use User\Model\User as User;
use User\Model\Guest;
use Laminas\Log\Logger as Logger;

abstract class AbstractController extends AbstractActionController
{

    public $baseUrl;
    /**
     * 
     * @var $referringUrl 
     */
    public $referringUrl;
    
    public $authService;
    /**
     * @var $user User\Model\User
     */
    public $user;
    /**
     * 
     * @var $logger Laminas\Log\Logger
     */
    public $logger;
    /**
     * 
     * @var $view Laminas\View\Model\ViewModel
     */
    public $view;
    /**
     * 
     * @var $table User\Model\UserTable
     */
    public $table;
    /**
     * 
     * @var $acl Laminas\Permission\Acl
     */
    public $acl;

    public $authenticated = false;
    
    /**
     * 
     * @var $config array
     */
    public $config;
    /**
     * 
     * @var $appSettings Laminas\Config\Config
     */
    public $appSettings;
    
    protected $action;

    protected $sessionContainer;

    public function onDispatch(MvcEvent $e)
    {
        // Get an instance of the Service Manager
        $sm = $e->getApplication()->getServiceManager();
        // Request Object
        $request = $sm->get('Request');
        // The Referring Url for the current request ie the previous page
        $this->referringUrl = $request->getServer()->get('HTTP_REFERER');
        // The Logger Service
        $this->logger = $sm->get('Laminas\Log\Logger');
        // Not sure why we need this....
        $this->baseUrl = $this->getRequest()->getBasePath();
        // The authentication Object
        $this->authService = new AuthService();
        // This removes the need for more than one db query to make settings available to Aurora
        $this->appSettings = $sm->get('AuroraSettings');
        // This may be removed in next branch
        $pluginManager = $sm->get('ControllerPluginManager');
        //TODO remove this call in next brach
        $fm = $pluginManager->get('FlashMessenger');
        // An instance of User\Model\User
        $table = $sm->get('User\Model\UserTable');
        // An instance of the Acl Service
        $this->acl = $sm->get('Acl');
        // The default View Model so that we always have the same object
        $this->view = new ViewModel();
        // Is the User Authenticated?
        switch ($this->authService->hasIdentity()) {
            case true :
                $this->authenticated = true;
                $this->user = $table->getCurrentUser($this->authService->getIdentity());
                //$this->user->userName = 'testing';
                //$this->user->save();
                //var_dump($this->user);
                break;
            default;
                $user = new Guest();
                $this->user = $user;
                break;
        }
        $this->view->setVariable('appSettings', $this->appSettings);
        $this->layout()->appSettings = $this->appSettings;
        $this->view->user = $this->user;
        $this->view->acl = $this->acl;
        $this->action = $this->params()->fromRoute('action');
        $this->layout()->acl = $this->acl;
        $this->layout()->user = $this->user;
        $this->layout()->authenticated = $this->authenticated;
        $this->_init();
        return parent::onDispatch($e);
    }
    public function _init()
    {
        return $this;
    }
}