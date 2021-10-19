<?php
namespace User\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Mvc\Controller\Plugin\Layout;
use User\Model\UserTable;
use User\Model\User;
use User\Form\UserForm;


class UserController extends AbstractActionController
{
    // Add this property:
    private $table;
    
    // Add this constructor:
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        //$layout = new Layout();
        //$view = new ViewModel();
        
        $form = new UserForm();
        $form->get('submit')->setValue('Add');
        
            $view = new ViewModel([
                'Users' => $this->table->fetchAll(),
            ]);
        
            $child = new ViewModel(['form' => $form]);
            $child->setTemplate('User/User/form');
            
            $view->addChild($child, 'form_template');
           // var_dump($view);
            return $view;
    }
    
    public function addAction()
    {
        
        //var_dump($data);
//         $post = new User([]);
//         $post->id = $data['id'];
//         $post->artist = $data['artist'];
//         $post->title = $data['title'];
//         var_dump($post);
//         $this->table->saveUser($post);

        $form = new UserForm();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $User = new User();
        $form->setInputFilter($User->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $User->exchangeArray($form->getData());
        $this->table->saveUser($User);
        return $this->redirect()->toRoute('User');
        
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $id) {
            return $this->redirect()->toRoute('User', ['action' => 'add']);
        }
        
        // Retrieve the User with the specified id. Doing so raises
        // an exception if the User is not found, which should result
        // in redirecting to the landing page.
        try {
            $User = $this->table->getUser($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('User', ['action' => 'index']);
        }
        
        $form = new UserForm();
        $form->bind($User);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        
        if (! $request->isPost()) {
            return $viewData;
        }
        
        $form->setInputFilter($User->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return $viewData;
        }
        
        try {
            $this->table->saveUser($User);
        } catch (\Exception $e) {
        }
        
        // Redirect to User list
        return $this->redirect()->toRoute('User', ['action' => 'index']);
    }
    
    public function deleteAction()
    {
    }
}