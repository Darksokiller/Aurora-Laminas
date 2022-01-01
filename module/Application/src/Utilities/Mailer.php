<?php
namespace Application\Utilities;

use Laminas\Config\Config;
use Laminas\Http\PhpEnvironment\Request;
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
    /**
     * 
     * @var $appSettings \Laminas\Config\Config
     */
    protected $appSettings;
    /**
     * 
     * @var $request \Laminas\Http\PhpEnvironment\Request
     */
    protected $request;
    /**
     * 
     * @var $hostName string|HTTP_HOST
     */
    protected $hostName;
    /**
     * 
     * @var $requestScheme string|http https|REQUEST_SCHEME
     */
    protected $requestScheme;
    public $message;
    public $user;

    public function __construct(Config $settings = null, Request $request = null)
    {
        if(!empty($settings)) {
            $this->appSettings = $settings;
        }
        if(!empty($request)) {
            $this->request = $request;
            $this->hostName = $this->request->getServer('HTTP_HOST');
            $this->requestScheme = $this->request->getServer('REQUEST_SCHEME');
        }
        //var_dump($this->request->getServer());
        //var_dump($this->request);
    }
    public function sendMessage($email, $hash)
    {
        
        $message = new Message();
        $message->addTo($email);
        // This email must match the connection_config key in the options below
        $message->addFrom($this->appSettings->smtpSenderAddress);
        $message->setSubject($this->appSettings->appName . ' account verification');
        
        $message->setBody('Please click <a href="'.$this->requestScheme.'://'. $this->hostName .'/user/verify/'.$hash.'>here</a>"');
        
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