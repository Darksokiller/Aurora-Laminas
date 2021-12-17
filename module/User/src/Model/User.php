<?php
namespace User\Model;

use Application\Model\AbstractPrototype;
// use DomainException;
// use RuntimeException;
// use Laminas\Db\Adapter\AdapterInterface;
// use Laminas\Db\RowGateway\Exception;
// use Laminas\Permissions\Acl\ProprietaryInterface;
// use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
// use User\Model\UserTable as UserTable;
// use User\Model\Profile as Profile;
// use User\Model\ProfileTable as ProfileTable;
// use Laminas\Db\RowGateway\RowGateway;
// use Laminas\Db\Metadata\Metadata;
// use Laminas\Db\TableGateway\TableGateway;

class User extends AbstractPrototype implements RoleInterface
{
    protected $resourceId = 'user';
    protected $ownerId;
    protected $role;

    protected $tableName = 'user';

    protected $pk = 'id';


    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\ProprietaryInterface::getOwnerId()
     */
    public function getOwnerId()
    {
        // TODO Auto-generated method stub
        $this->ownerId = $this->id;
        return $this->ownerId;
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
}