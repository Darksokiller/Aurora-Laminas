<?php
namespace User\Controller;
use User\Model\UserTable;
use Application\Controller\AbstractAdminController;

class AdminController extends AbstractAdminController
{
    
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
        var_dump($this->user);
    }
}