<?php
namespace User\Controller;

use \RuntimeException;
use Application\Controller\AbstractController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
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
    /**
     * 
     * @var $table UserTable
     */
    public $table;
    // Add this constructor:
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }
    public function _init() {}
    public function indexAction()
    {
        $this->view->setVariable('users', $this->table->fetchAll());
        return $this->view;
    }
    public function editAction()
    {
        try {
            // get the user by userName that is to be edited
            $userName = $this->params()->fromRoute('userName');
            // this is the proper fetch for a user, all other calls are to be removed
            $user = $this->table->fetchByColumn('userName', $userName);
            // if they can not edit the user there is no point in preceeding
            if( ! $this->acl->isAllowed($this->user, $user, $this->action) ) {
                $this->flashMessenger()->addWarningMessage('You do not have the required permissions to edit other users');
                $this->redirect()->toUrl('/forbidden');
            }
            else {
                // since they can edit lets proceed
                $form = new UserForm();
                $form->get('submit')->setAttribute('value', 'Edit');
                $request = $this->getRequest();
                // if this is not a post lets return early
                $viewData['id'] = $user->id;
                if (! $request->isPost()) {
                    // bind the queried user data to the form
                    $form->bind($user);
                    // we should only need this when its not post, when form is initially built
                    $viewData['form'] = $form;
                    return $viewData;
                }
                
                // Set the input filters in the form object
                $form->setInputFilter($form->getInputFilter());
                // Set the posted data in the form so that it can be validated
                $form->setData($request->getPost());
                // Validate the posted data via the filters set in the form object
                // TODO: Fix this, this form object has no filters or validators defined in the form class
                if (! $form->isValid()) {
                    //return $viewData;
                    $viewData['form'] = $form;
                    return $viewData;
                }
                $user->populate($form->getData(), true);
                
                $result = $user->save();
                if($result) {
                    // Redirect to User list
                    return $this->redirect()->toRoute('user', ['action' => 'index']);
                }
                else {
                    throw new \RuntimeException('The user could not be updated at this time');
                }
                
            }
        } catch (RuntimeException $e) {
        }
    }
    
    public function deleteAction()
    {
    }
    public function logoutAction()
    {
        //var_dump($this->authService->hasIdentity());
        //var_dump($this->authService->getIdentity());
       // die(__FILE__ . '::' . __LINE__);
       // $this->authService->clearIdentity();
       // $sm = $this->getEvent()->getApplication()->getServiceManager();
        //$session = $sm->get('Laminas\Session');
        //var_dump($_SESSION);
        switch ($this->authService->hasIdentity())
        {
            case true :
                //var_dump($this->authService->getIdentity());
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
        // get the post data
        $post = $request->getPost();
        // set the input filters on the form object
        $form->setInputFilter($form->getLoginFilter());
        // set the posted data in the form objects context
        $form->setData($request->getPost());
        // check with the form object to verify data is valid
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        $validData = $form->getData();
        $user = new User($this->table->getUserByEmail($validData['email']));
        $user->password = $validData['password'];
        $loginResult = $this->table->login($user);
        if($loginResult instanceof User)
        {
            $this->flashMessenger()->addInfoMessage('Welcome back!!');
            $this->redirect()->toRoute('profile', ['userName' => $loginResult->userName]);
        }
        else {
            return $this->redirect()->toUrl('/user/login-failure');
        }
    }
    public function loginFailureAction()
    {
        return new ViewModel(['messages' => 'failed login']);
    }
}