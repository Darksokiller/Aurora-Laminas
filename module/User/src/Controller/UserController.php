<?php
namespace User\Controller;

use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
//use Laminas\Log\Formatter\FirePhp;
use Laminas\Log\Formatter\FirePhp as Formatter;
use Laminas\Log\Writer\FirePhp as Writer;
use Laminas\Log\Logger;
use User\Model\UserTable;
use User\Model\User;
use User\Form\UserForm;
use User\Form\LoginForm;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Validator\Db\NoRecordExists as Validator;
use User\Form\RegistrationForm;



class UserController extends AbstractController
{
    // Add this property:
    public $table;
    const MAIL_SENDER = 'devel@webinertia.net';
    const MAIL_PASSWORD = '**bffbGfbd88**';
    // Add this constructor:
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }
    public function _init() {
        $this->table->setAcl($this->acl);
    }
    public function indexAction()
    {
        $this->view->setVariable('users', $this->table->fetchAll());

            return $this->view;
    }
    
    public function registerAction()
    {

        
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        try {
            $user = $this->table->getUser($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('user', ['action' => 'index']);
        }
        
        switch ($this->acl->isAllowed($this->user, $user, $this->action)) {
            case true:
                
                if (0 === $id) {
                    return $this->redirect()->toRoute('user', ['action' => 'edit']);
                }
                
                // Retrieve the User with the specified id. Doing so raises
                // an exception if the User is not found, which should result
                // in redirecting to the landing page.
                try {
                    $user = $this->table->getUser($id);
                } catch (\Exception $e) {
                    return $this->redirect()->toRoute('user', ['action' => 'index']);
                }
                
                $form = new UserForm();
                $form->bind($user);
                $form->get('submit')->setAttribute('value', 'Edit');
                
                $request = $this->getRequest();
                $viewData = ['id' => $id, 'form' => $form];
                
                if (! $request->isPost()) {
                    return $viewData;
                }
                
                $form->setInputFilter($user->getInputFilter());
                
                $form->setData($request->getPost());
                
                if (! $form->isValid()) {
                    return $viewData;
                }
                
                try {
                    $this->table->saveUser($user);
                } catch (\Exception $e) {
                }
                
                // Redirect to User list
                return $this->redirect()->toRoute('user', ['action' => 'index']);
                
                break;
            case false:
                $this->flashMessenger()->addWarningMessage('You do not have the required permissions to edit other users');
                $this->redirect()->toUrl('/forbidden');
                //die('we do not have permission');
                break;
        }
        
        
        
    }
    
    public function deleteAction()
    {
    }
    public function logoutAction()
    {

        switch ($this->authService->hasIdentity())
        {
            case true :
                $this->authService->clearIdentity();
                return $this->redirect()->toUrl('/');
                break;
            case false:
                
                break;
            default:
                
                break;
        }
    }
    public function loginAction()
    {
        
        $form = new LoginForm();
        $form->get('submit')->setValue('Login');
        
        $request = $this->getRequest();
        
        
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        /** does the passwords match? if not show them the form again without the passwords
         * eventually need to replace this with a chained filter or validator
         */
        // hash $2y$10$ncO3bgCRcWaCdeINBffN4eDBAuRnhden9eZd6hXQIttrGc1hjoFlO
        $post = $request->getPost();
        
        $user = new User();
        
        //var_dump($this->table->login($user, $password = 'test'));
        
        $form->setInputFilter($user->getLoginFilter());
        $form->setData($request->getPost());
        // var_dump($form->getData());
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $user->exchangeArray($form->getData());
        //var_dump($user);
        //$this->table->login($user);
        if($this->table->login($user))
        {
            //$this->redirect()->toUrl('/user/profile/view/'. $user->id);
            $this->flashMessenger()->addInfoMessage('Welcome back!!');
            $this->redirect()->toRoute('profile', ['id' => $user->id]);
        }
        else {
            return $this->redirect()->toUrl('/user/login-failure');
        }
        //return $this->redirect()->toRoute('user');
        
    }
    public function loginFailureAction()
    {
        return new ViewModel(['messages' => 'failed login']);
    }
}