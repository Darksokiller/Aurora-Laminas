<?php
namespace User\Controller;
use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
//use Laminas\Log\Formatter\FirePhp;
use Laminas\Log\Formatter\FirePhp as Formatter;
use Laminas\Log\Writer\FirePhp as Writer;
use Laminas\Log\Logger;
use User\Model\UsersTable;
use User\Model\Users;
use User\Form\UserForm;
use User\Form\LoginForm;
use Laminas\Mvc\View\Http\ViewManager;

class ProfileController extends AbstractController
{
    public function __construct(UsersTable $table)
    {
        $this->table = $table;
    }
    public function _init()
    {
        if(!$this->authenticated)
        {
            $this->redirect()->toUrl('/user/login');
        }
        parent::_init();
    }
    public function indexAction()
    {
        var_dump($this->user);
        //$applicatio
        //var_dump($_SESSION['user']['details']);
        return new ViewModel(['messages' => ['welcome' => 'Welcome back!!']]);
    }
}