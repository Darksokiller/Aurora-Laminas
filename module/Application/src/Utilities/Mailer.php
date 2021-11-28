<?php
namespace Application\Utilities;

use Application\Permissions\PermissionsManager;
use Application\Model\SettingsTable;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

/**
 *
 * @author Joey Smith
 *        
 */
class Mailer implements ResourceInterface
{
    private $acl;
    protected $appSettings;
    protected $resourceId = 'mailService';
    public $message;
    public $user;
    
    // TODO - Insert your code here
    
    /**
     */
    public function __construct($container)
    {
        //var_dump($container);
        // TODO - Insert your code here
    }
    public function getResourceId()
    {
        return $this->resourceId;
    }
}

