<?php
namespace Application\Controller;

// use Laminas\Db\TableGateway\TableGatewayInterface as TableGatewayInterface;
// use Laminas\Mvc\Application as Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session;
// use Laminas\Session\Container as SessionContainer;
use Laminas\Mvc\Exception;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService as AuthService;
use User\Model\UserTable as Table;
use User\Model\User as User;

class AbstractController extends AbstractActionController
{

    public $baseUrl;

    public $authService;

    public $user;

    public $table;

    public $acl;

    public $authenticated = false;

    protected $sessionContainer;

    public function onDispatch(MvcEvent $e)
    {
        $this->baseUrl = $this->getRequest()->getBasePath();
        $this->authService = new AuthService();
        $sm = $e->getApplication()->getServiceManager();
        $table = $sm->get('User\Model\UserTable');
        $this->acl = $sm->get('Application\Permissions\PermissionsManager');
        $this->acl = $this->acl->getAcl();
        $this->view = new ViewModel();
        
        switch ($this->authService->hasIdentity()) {
            case true :
                $this->authenticated = true;
                $this->user = $table->getUserByEmail($this->authService->getIdentity());
                break;
            default:
                $user = new User();
                $this->user = $user->exchangeArray([
                    'userName' => 'Guest',
                    'role' => 'guest'
                ]);
                break;
        }
        
        $this->user->password = null;
        $this->view->user = $this->user;
        $this->view->acl = $this->acl;
        $this->layout()->authenticated = $this->authenticated;
        $this->layout()->userName = $this->user->userName;
        $this->_init();
        return parent::onDispatch($e);
    }

    public function _init()
    {}
}
