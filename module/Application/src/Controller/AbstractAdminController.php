<?php
namespace Application\Controller;

use Application\Controller\AbstractController;

abstract class AbstractAdminController extends AbstractController
{

    public function _init()
    {
        if(!$this->acl->isAllowed('admin', $this->user, 'admin.access'))
        {
            $this->flashMessenger()->addWarningMessage('You do not have sufficient privileges to access the requested area.');
            $this->redirect()->toRoute('forbidden');
        }
        $adminParent = 'Application\Controller\AbstractAdminController';
        switch ($adminParent === get_parent_class(get_called_class())) {
            case true:
                $this->layout('layout/admin');
                break;
            default:
                
                break;
        }
    }
}