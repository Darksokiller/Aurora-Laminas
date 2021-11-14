<?php
namespace User\Controller;
use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;
use User\Model\UserTable;

class ProfileController extends AbstractController
{
    public function __construct(UserTable $table)
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
        //var_dump($this->table->get);
        var_dump($this->user);
        //$applicatio
        //var_dump($_SESSION['user']['details']);
        return new ViewModel(['messages' => ['welcome' => 'Welcome back!!']]);
    }
    
}