<?php
namespace Application\Model\RowGateway;

use Laminas\Db\RowGateway\RowGateway;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
use Laminas\Permissions\Acl\ProprietaryInterface;

class ApplicationRowGateway extends RowGateway implements RoleInterface, ResourceInterface, ProprietaryInterface
{
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Resource\ResourceInterface::getResourceId()
     */
    public function getResourceId()
    {
        // TODO Auto-generated method stub
        return $this->table;
    }
    public function getArrayCopy()
    {
        return $this->toArray();
    }
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\ProprietaryInterface::getOwnerId()
     */
    public function getOwnerId()
    {
        // TODO Auto-generated method stub
        if($this->offsetExists('userId')) {
            return $this->offsetGet('userId');
        }
        return $this->offsetGet('id');
    }

    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Role\RoleInterface::getRoleId()
     */
    public function getRoleId()
    {
        // TODO Auto-generated method stub
        return $this->offsetGet('role');
    }

}