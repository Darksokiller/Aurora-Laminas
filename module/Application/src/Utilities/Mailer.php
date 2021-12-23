<?php
namespace Application\Utilities;

use Laminas\Permissions\Acl\Acl;
use Application\Model\SettingsTable;
use User\Model\User as User;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

/**
 *
 * smtp-relay.gmail.com on port 587.
 */

/**
 *
 * @author Joey Smith
 *        
 */
class Mailer implements ResourceInterface
{
    const RESOURCE_ID = 'mailService';
    /**
     * 
     * @var $acl Acl
     */
    private $acl;
    protected $appSettings;
    public $message;
    public $user;

    public function __construct()
    {
        $args = func_get_args();
        //var_dump($args);
        //var_dump($container);
        // TODO - Insert your code here
    }
    public function sendMessage($email, $hash)
    {
        
        $message = new Message();
        $message->addTo($user->email);
        // This email must match the connection_config key in the options below
        $message->addFrom($this->appSettings->smtpSenderAddress);
        $message->setSubject($this->appSettings->siteName . ' account verification');
        
        $message->setBody('Please click the link to verify your account ');
        
        $transport = new SmtpTransport();
        
        $options   = new SmtpOptions([
            'name' => 'webinertia.net',
            'host' => 'smtp-relay.gmail.com',
            'port' => '587',
            'connection_class'  => 'login',
            'connection_config' => [
                'username' => $this->appSettings->smtpSenderAddress,
                'password' => $this->appSettings->smtpSenderPasswd,
                'ssl' => 'tls',
            ],
        ]);
        $transport->setOptions($options);
        $transport->send($message);
    }
    
    public function getResourceId()
    {
        return $this->resourceId;
    }
    
}