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



class UserController extends AbstractController
{
    // Add this property:
    private $table;
    
    // Add this constructor:
    public function __construct(UsersTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        
            $view = new ViewModel([
                'users' => $this->table->fetchAll(),
            ]);
        
            
           // var_dump($view);
            return $view;
    }
    
    public function addAction()
    {
        
        $form = new UserForm();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        /** does the passwords match? if not show them the form again without the passwords
         * evenutally need to replace this with a chained filter or validator
         */
        $post = $request->getPost();
        //var_dump($post);
        if($post['password'] !== $post['conf_password'])
        {
            return ['form' => $form]; 
        }
    
        $user = new User();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());
       // var_dump($form->getData());
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);
        return $this->redirect()->toRoute('user');
        
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $id) {
            return $this->redirect()->toRoute('user', ['action' => 'add']);
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
    }
    
    public function deleteAction()
    {
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
        
        //var_dump(password_verify('bffbGfbd88', '$2y$10$ncO3bgCRcWaCdeINBffN4eDBAuRnhden9eZd6hXQIttrGc1hjoFlO'));
        
        $user = new Users();
        
        //var_dump($this->table->login($user, $password = 'test'));
        
        $form->setInputFilter($user->getLoginFilter());
        $form->setData($request->getPost());
        // var_dump($form->getData());
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $user->exchangeArray($form->getData());
        //var_dump($user);
        $this->table->login($user);
        //return $this->redirect()->toRoute('user');
        
    }
}