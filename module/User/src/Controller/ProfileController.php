<?php
namespace User\Controller;
use Application\Controller\AbstractController;
use User\Model\UserTable;
use \RuntimeException;

class ProfileController extends AbstractController
{
    protected $profileTable;
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }
    public function _init()
    {
       // var_dump($this->getEvent()->getApplication()->getServiceManager());
        $sm = $this->getEvent()->getApplication()->getServiceManager();
        $this->profileTable = $sm->get('User\Model\ProfileTable');
        
        if(!$this->authenticated) {
            $this->redirect()->toUrl('/user/login');
        }
    }
    public function viewAction()
    {
        try {
            $userName = $this->params()->fromRoute('userName');
            $requestedUser = $this->table->fetchByColumn('userName', !empty($userName) ? $userName : $this->user->userName);
            $profileData = $this->profileTable->fetchByColumn('userId', $requestedUser->id);
            $previous = substr($this->referringUrl, -5);
            if($previous === 'login') {
                $this->logger->info('User ' . $this->user->userName . ' logged in.', [
                    'userId' => $this->user->id,
                    'userName' => $this->user->userName,
                    'firstName' => ! empty($profileData->firstName) ? $profileData->firstName : null,
                    'lastName' => ! empty($profileData->lastName) ? $profileData->lastName : null
                ]);
            }
            return $this->view->setVariable('data', $profileData);

        } catch (RuntimeException $e) {
            //$this->logger->err($e->getMessage());
        }
    }
}