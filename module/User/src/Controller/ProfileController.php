<?php
namespace User\Controller;
use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;
use User\Model\UserTable;
use \Exception;

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
       // var_dump($this->profileTable);
        
        if(!$this->authenticated)
        {
            $this->redirect()->toUrl('/user/login');
        }
        //parent::_init();
    }
    public function viewAction()
    {
        try {
            $userName = (int) $this->params()->fromRoute('userName');
            $user = $this->table->fetchByColumn('userName', $userName);
            switch(!empty($userName)) {
                case true:
                    $this->view->setVariable('data', $user);
                    break;
                default:
                    // we only wanna log this if $userId = 0 since that means they are coming in from the login redirect
                        try {
                            $pData = $this->profileTable->fetchById($user->id);
                            $user = $this->user;
                            // by this point it should be safe to assume we have a logged in user with atleast an id and userName
                            $previous = substr($this->referringUrl, -5); // looking for login ;)
                            if($previous === 'login') {
                                $this->logger->info('User ' . $this->user->userName . ' logged in.', [
                                    'userId' => $this->user->id,
                                    'userName' => $this->user->userName,
                                    'firstName' => ! empty($pData->firstName) ? $pData->firstName : null,
                                    'lastName' => ! empty($pData->lastName) ? $pData->lastName : null
                                ]);
                            }
                            // Set the profile data in the $data view variable
                            $this->view->setVariable('data', $pData);
                            // return the view object
                            return $this->view;
                        } catch (Exception $e) {
                            //$this->logger->err($e->getMessage());
                        }
                    break;
            }
            
            return $this->view;
        } catch (Exception $e) {
            //$this->logger->err($e->getMessage());
        }
        
        
        
    }
    
}