<?php
namespace Application\Utilities;

use Application\Permissions\PermissionsManager;
use Application\Model\SettingsTable;
use User\Model\User as User;

use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\SmtpOptions;

use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\SharedEventManagerInterface;

/**
 *
 * smtp-relay.gmail.com on port 587.
 */

/**
 *
 * @author Joey Smith
 *        
 */
class Mailer implements ResourceInterface, EventManagerAwareInterface
{
    private $acl;
    protected $events;
    protected $appSettings;
    protected $resourceId = 'mailService';
    public $message;
    public $user;

    public function __construct()
    {
        //var_dump($container);
        // TODO - Insert your code here
    }
    public function sendMessage($userId = 0, $message, $sendTo)
    {
        $message = new Message();
        $message->addTo($post['email']);
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
    
    public function setEventManager(EventManagerInterface $events)
    {
        $events->setIdentifiers([
            __CLASS__,
            get_class($this),
        ]);
        $this->events = $events;
    }
    
    public function getEventManager()
    {
        if (! $this->events) {
            $this->setEventManager(new EventManager());
        }
        return $this->events;
    }

    public function getResourceId()
    {
        return $this->resourceId;
    }
    
}