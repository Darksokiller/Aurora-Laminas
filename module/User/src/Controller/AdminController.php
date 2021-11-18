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

//     public function _init()
//     {
//         $adminParent = 'Application\Controller\AbstractAdminController';
//         switch ($adminParent === get_parent_class(get_called_class())) {
//             case true:
//                 $this->layout('layout/admin');
//                 break;
//             default:
                
//                 break;
//        }
//     }
    public function indexAction()
    {
        
    }
}