<?php
namespace Application\Model;

//use RuntimeException;
//use Laminas\Session;
//use User\Model\User as User;
use Application\Model\LoggableEntity;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Application\Permissions\PermissionsManager as Acl;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;

abstract class AbstractModel implements ResourceInterface, ProprietaryInterface
{
    protected $tableGateway;
    public $acl;
    protected $logger;
    protected $dependentTables;
    /**
     * 
     * @param TableGatewayInterface $tableGateway
     * @param array $dependentTables | array keys are dependent table Classnames with either a null | object value Laminas\Db\TableGateway\TableGateway
     * @param Logger $logger
     */
    public function __construct(TableGatewayInterface $tableGateway)
    {
        //var_dump(func_get_args());
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