<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\UserForm;
use User\Form\LoginForm;
use User\Form\RegistrationForm;
use User\Model\User;
use User\Model\UserTable;
use User\Filter\RegistrationHash as Filter;
use User\Filter\FormFilters;
use Laminas\Validator\Db\NoRecordExists as Validator;
use Application\Utilities\Mailer;
use Application\Event\LogEvents;


/**
 * RegisterController
 * 
 * @author Joey Smith
 * @version 1.0 Alpha 1.0
 */
class RegisterController extends AbstractController
{
    public $table;
    public function __construct(UserTable $table)
    {
        $this->table = $table;
    }
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
        $formFilters = new FormFilters(null, $this->table);
        $sm = $this->getEvent()->getApplication()->getServiceManager();
        //$this->logger
        $mailer = $sm->get('Application\Utilities\Mailer');
        //var_dump($mailer);
        //$mailer->setEventManager($events);
        //var_dump($mailer);
       // $logger->info('test message', ['userId' => $this->user->id]);
       // $mailer->send($this->user->id, 'this is a test registration email', 'someuser@domain.com');
        
        if($this->appSettings->disableRegistration) {
           return $this->view; 
        }
        $form = new UserForm('RegistrationForm', $this->appSettings->toArray());
        $form->get('submit')->setValue('Register');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            // Initial page load, send them the form
            return $this->view->setVariable('form', $form);
        }
        // if weve made it to here then its a post request
        $post = $request->getPost();
        // we have to have a new one of these so we can hydrate it and call the dbadapter for the validators
        
        //$user->setDbAdapter($this->table->getAdapter());
        $form->setInputFilter($formFilters->getInputFilter());
        $form->setData($request->getPost());
        // Is the posted form data valid? if not send them the form back and the problems 
        // reported by the filters and validators
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        // at this point the form has posted and were ready to kick this off
        $now = new \DateTime();
        // time format is 02/13/1975
        $timeStamp = $now->format($this->appSettings->timeFormat);
        
        // get  the valid data from the form, we need to add to it before user is saved
        $formData = $form->getData();
        $hash = new Filter($formData['email'], $timeStamp);
        $hash = $hash->getHash();
        
        //$user = new User($this->table->getAdapter());
        
        $formData['regDate'] = $timeStamp;
        $formData['regHash'] = $hash;
        
        $result = $this->table->save($formData);
        if($result > 0) {
            $mailer->sendMessage($formData['email'], $hash);
        }
    }
    public function verifyAction()
    {
        //$mailer = $this->getEvent()->getApplication()->getServiceManager()->get('Application\Utilities\Mailer');
        $token = $this->params('token');
        var_dump($token);
    }
}