<?php

namespace User\Controller;

use Application\Controller\AbstractController;
use User\Form\UserForm;
use User\Form\LoginForm;
use User\Form\RegistrationForm;
use User\Model\User;
use User\Model\UserTable;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Validator\Db\NoRecordExists as Validator;


/**
 * {0}
 * 
 * @author
 * @version 
 */
class RegisterController extends AbstractController
{
    const MAIL_SENDER = 'devel@webinertia.net';
    const MAIL_PASSWORD = '**bffbGfbd88**';
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
//         $regForm = new RegistrationForm();
//         return['regForm'=> $regForm];
        
        $form = new UserForm();
        //$form->setOption('dbAdapter', $this->table->getAdapter());
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            return $this->view->setVariable('form', $form);
           // return ['form' => $form];
        }
        /** does the passwords match? if not show them the form again without the passwords
         * evenutally need to replace this with a chained filter or validator
         */
        $post = $request->getPost();
        //var_dump($post);
//         if($post['password'] !== $post['conf_password'])
//         {
//             return ['form' => $form];
//         }
        
        $user = new User();
        $user->setDbAdapter($this->table->getAdapter());
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());
        // var_dump($form->getData());
        if (! $form->isValid()) {
            return ['form' => $form];
        }

        //var_dump($this->table->getAdapter());
        $now = new \DateTime();
        $now->setTimezone(new \DateTimeZone('America/Chicago'));
        //var_dump($now->format('j-m-Y g:i:s'));
        //var_dump($now->getTimezone());
        // return;
        /**
         *
         * smtp-relay.gmail.com on port 587.
         */
        $message = new Message();
        $message->addTo('jsmith@webinertia.net');
        $message->addFrom('devel@webinertia.net');
        $message->setSubject('Did ya get that one?');
        $message->setBody("Hey, guess what, its still working lmao");
        
        $transport = new SmtpTransport();
        $options   = new SmtpOptions([
            'name' => 'webinertia.net',
            'host' => 'smtp-relay.gmail.com',
            'port' => '587',
            'connection_class'  => 'login',
            'connection_config' => [
                'username' => 'devel@webinertia.net',
                'password' => self::MAIL_PASSWORD,
                'ssl' => 'tls',
            ],
        ]);
        $transport->setOptions($options);
        $transport->send($message);
        
        
        $user->exchangeArray($form->getData());
        $this->table->saveUser($user);
        return $this->redirect()->toRoute('user');
    }
}