<?php
namespace Application\Model;

//use RuntimeException;
//use Laminas\Session;
//use User\Model\User as User;
use Laminas\Db\TableGateway\TableGatewayInterface;
//use Laminas\Validator\EmailAddress as emailValidater;
//use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
//use Laminas\Authentication\AuthenticationService as AuthService;
//use Laminas\Authentication\Result;
use Application\Permissions\PermissionsManager as Acl;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

abstract class AbstractModel implements ResourceInterface, ProprietaryInterface
{
    protected $tableGateway;
    public $acl;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->_init();
    }
    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }
    public function _init()
    {
        return $this;
    }
    public function setAcl($acl)
    {
        $this->acl = $acl;
    }
    public function getAcl()
    {
        return $this->acl;
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Resource\ResourceInterface::getResourceId()
     */
    public function getResourceId()
    {
        // TODO Auto-generated method stub
        return $this->tableGateway->getTable();
    }

    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\ProprietaryInterface::getOwnerId()
     */
    public function getOwnerId()
    {
        // TODO Auto-generated method stub
        
    }
    
}