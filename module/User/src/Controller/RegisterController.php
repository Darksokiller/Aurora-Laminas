<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\UserForm;
use User\Form\LoginForm;
use User\Form\RegistrationForm;
use User\Model\User;
use User\Model\UserTable;
use User\Filter\RegistrationHash as Filter;

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
       // $this->table->setEventManager($this->getEventManager());
        //var_dump($this->table);
    }
	/**
	 * The default action - show the home page
	 */
    public function indexAction()
    {
        $sm = $this->getEvent()->getApplication()->getServiceManager();
        //$this->logger
        $mailer = $sm->get('Application\Utilities\Mailer');
        //$mailer->setEventManager($events);
        //var_dump($mailer);
       // $logger->info('test message', ['userId' => $this->user->id]);
       // $mailer->send($this->user->id, 'this is a test registration email', 'someuser@domain.com');
        
        if($this->appSettings->disableRegistration) {
           return $this->view; 
        }
        $form = new UserForm();
        $form->get('submit')->setValue('Register');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            // Initial page load, send them the form
            return $this->view->setVariable('form', $form);
        }
        // if weve made it to here then its a post request
        $post = $request->getPost();
        // we have to have a new one of these so we can hydrate it and call the dbadapter for the validators
        $user = new User();
        $user->setDbAdapter($this->table->getAdapter());
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());
        // Is the posted form data valid? if not send them the form back and the problems 
        // reported by the filters and validators
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        // at this point the form has posted and were ready to kick this off
        $now = new \DateTime();
        // set the time zone to central this will need replaced by a setting from the settings table
        //$now->setTimezone(new \DateTimeZone('America/Chicago'));
        // time format is 02/13/1975
        $now->format($this->appSettings->timeFormat);
        
        $filter = new Filter();
        // get  the valid data from the form, we need to add to it before user is saved
        $formData = $form->getData();
        $hash = new Filter($formData['email'], $now);
        $hash = $hash->getHash();
        //$user->exchangeArray($form->getData());
        $user = new User($formData);
        $user->regDate = $now;
        $user->regHash = $hash;
        $this->table->save($user);
        return $this->redirect()->toRoute('user');
    }
    public function verifyAction()
    {
        $mailer = $this->getEvent()->getApplication()->getServiceManager()->get('Application\Utilities\Mailer');
        $token = $this->params('token');
    }
}