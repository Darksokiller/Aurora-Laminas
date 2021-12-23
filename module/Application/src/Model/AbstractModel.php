<?php
namespace Application\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\TableGateway\TableGateway;
use Application\Permissions\PermissionsManager as Acl;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;

abstract class AbstractModel implements ResourceInterface, ProprietaryInterface
{
    /**
     * 
     * @var $tableGateway TableGateway
     */
    protected $tableGateway;
    /**
     * 
     * @var $logger Laminas\Log\Logger
     */
    protected $logger;
    /**
     * 
     * @var $dependentTables TableGateway
     */
    protected $dependentTables;
    /**
     * 
     * @var $acl Laminas\Permissions\Acl\Acl
     */
    public $acl;

    public function __construct(TableGateway $tableGateway)
    {
        //var_dump(func_get_args());
        $this->tableGateway = $tableGateway;
        $this->_init();
    }
    public function getAdapter()
    {
        return $this->tableGateway->getAdapter();
    }
    /**
     * 
     * @return \Application\Model\AbstractModel
     */
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