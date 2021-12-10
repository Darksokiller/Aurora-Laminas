<?php
namespace User\Model;
use Laminas\Permissions\Acl\Role\RoleInterface;
/**
 *
 * @author acesn
 *        
 */
class Guest implements RoleInterface
{
    protected $roleId = 'guest';
    public $userName = 'Guest';
    public $role = 'guest';
    /**
     * {@inheritDoc}
     * @see \Laminas\Permissions\Acl\Role\RoleInterface::getRoleId()
     */
    public function getRoleId()
    {
        // TODO Auto-generated method stub
        return $this->roleId;
    }


}

