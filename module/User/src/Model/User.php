<?php
namespace User\Model;
use DomainException;
use RuntimeException;
use Laminas\Db\RowGateway\Exception;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
use User\Model\UserTable as UserTable;
use User\Model\Profile as Profile;
use User\Model\ProfileTable as ProfileTable;
use Laminas\Db\RowGateway\RowGateway;

class User implements RoleInterface, ResourceInterface, ProprietaryInterface
{
    protected $resourceId = 'user';
    protected $dbAdapter;
    public $row;
    
    public function __construct(RowGateway $row = null, UserTable $table = null, array $rowData = [])
    {
        try {
            switch ($row instanceof RowGateway) {
                // If this is true then we have been passed the return of a query as argument one
                case true:
                    $this->row = $row;
                    break;
                case false:
                        if($row == null && !$table instanceof UserTable) {
                            throw new RuntimeException('You must pass either a instance of Rowgateway as argument one or an instance of User\Model\UserTable as arguments two');
                        }
                        $this->row = new RowGateway('id', 'user', $table->getAdapter());
                        // create an instance with an empty context, ie creating a new user
                        $this->row->populate($rowData, false);
                break;
            }
            
        } catch (RuntimeException $e) {
            
        }
    }
    public function __get($name)
    {
        return $this->row->{$name};
    }
    public function __set($name, $value)
    {
        $this->row->{$name} = $value;
    }
    public function __call($method, $args)
    {
        $this->row->{$method}($args);        
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\ProprietaryInterface::getOwnerId()
     */
    public function getOwnerId()
    {
        // TODO Auto-generated method stub
        return $this->id;
    }
    
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Role\RoleInterface::getRoleId()
     */
    public function getRoleId()
    {
        // TODO Auto-generated method stub
        return $this->role;
    }
    public function getResourceId()
    {
        return $this->resourceId;
    }
    // Add the following method:
    public function getArrayCopy()
    {
        return $this->row->toArray();
    }
    /**
     * @return the $dbAdapter
     */
    public function getDbAdapter()
    {
        return $this->dbAdapter;
    }
    /**
     * @param field_type $dbAdapter
     */
    public function setDbAdapter($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
}