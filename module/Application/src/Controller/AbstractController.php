<?php
namespace Application\Controller;
//use Laminas\Db\TableGateway\TableGatewayInterface as TableGatewayInterface;
//use Laminas\Mvc\Application as Application;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session;
//use Laminas\Session\Container as SessionContainer;
use Laminas\Mvc\Exception;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;
use Laminas\Authentication\AuthenticationService as AuthService;
use User\Model\UsersTable as Table;
//use User\Model\Users;

class AbstractController extends AbstractActionController
{
    public $baseUrl;
    public $authService;
    public $user = [];
    public $table;
    public $authenticated = false;
    protected $sessionContainer;
    
    public function onDispatch(MvcEvent $e) {
        $this->baseUrl = $this->getRequest()->getBasePath();
        //die('running');
       //var_dump($_SESSION);
        //var_dump($_SESSION['user']['details']);
       //var_dump($_SESSION['Laminas_Auth']['storage']);
       
       $this->authService = new AuthService();
       $sm = $e->getApplication()->getServiceManager();
       $table = $sm->get('User\Model\UsersTable');
       //var_dump($table);
       $this->view = new ViewModel();
       $userName = 'Guest';
       if($this->authService->hasIdentity())
       {
            $this->authenticated = true;
            $this->user = $table->getUserByEmail($this->authService->getIdentity());
            $userName = $this->user->name;
           // $this->view->setVariable('userName', $this->user->name);
       }
       else {
           //$this->view->setVariable('userName', 'Guest');
           
           //$this->redirect()->toUrl('/');
       }
      // var_dump($this->authService->getIdentity());
       $this->layout()->authenticated = $this->authenticated;
       $this->layout()->userName = $userName;
       $this->_init();
        return parent::onDispatch($e);
    }
    public function _init()
    {
       
    }
    
}
