<?php
namespace User\Permissions;
use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Assertion\OwnershipAssertion as Owner;
use User\Model\RolesTable;

class PermissionsManager
{
    /**
     * 
     * @var $acl \Laminas\Permissions\Acl\Acl
     */
    public $acl;
    /**
     * 
     * @var $table \User\Model\RolesTable
     */
    protected $table;
    /**
     * 
     * @var $roles \Laminas\Db\ResultSet\ResultSet
     */
    private $roles;
    /**
     * 
     * @var $role \User\Model\
     */
    private $role;
    
    public function __construct(Acl $acl, RolesTable $rolesTable = null) {
        $this->table = $rolesTable ?? null;
        $this->acl = $acl;
        $this->build();
        return $this;
    }
    /**
     * 
     * @return \Application\Permissions\PermissionsManager
     * Provides fluent interface
     */
    public function build()
    {
        $guest = new Role('guest');
        $this->acl->addRole($guest);
        $this->acl->addRole(new Role('user', $guest));
        $this->acl->addRole(new Role('moderator', 'user'));
        $this->acl->addRole(new Role('admin'));
        $this->acl->addRole(new Role('superAdmin', 'admin'));
        
        $this->acl->addResource('user');
        $this->acl->addResource('user_profile');
        $this->acl->addResource('project');
        $this->acl->addResource('album');
        $this->acl->addResource('admin');
        $this->acl->addResource('settings');
        $this->acl->addResource('mailService');
        
        $this->acl->allow('guest', null, 'view');
        $this->acl->allow('user', null, 'view');
        $this->acl->allow('guest', 'user', ['register.view', 'login.view']);
        $this->acl->allow('user', 'user', 'logout');
        $this->acl->allow('user', 'user', 'user.view.list');

        
        $this->acl->deny('user', 'user', ['register', 'login', 'user.create.new']);
        
        $this->acl->deny(['guest', 'user'], 'admin', 'admin.access');
        
        $this->acl->allow('user', null, ['edit', 'delete'], new Owner());
        $this->acl->allow('user', 'album', 'album.create');
        //$this->acl->allow('user', 'user', 'edit', new Owner());
        $this->acl->allow('user', 'user_profile', 'edit', new Owner());
        $this->acl->allow('user', 'project', 'edit', new Owner());
        $this->acl->allow('admin', 'admin', ['admin.access', 'admin.settings', 'admin.user']);
        $this->acl->allow('admin');
        
        //$this->acl->deny('admin', 'user', ['register', 'login']);
        $this->acl->deny('admin', 'admin', 'admin.add.setting');
        $this->acl->allow('superAdmin');
        //$this->acl->deny(['admin', 'superAdmin'], 'user', ['register.view', 'login.view']);
        
        return $this;
    }
    public function getRoles()
    {
        return $this->roles;
    }
    /**
     * @return the $acl
     */
    public function getAcl()
    {
        return $this->acl;
    }

    /**
     * @param \Laminas\Permissions\Acl\Acl $acl
     */
    public function setAcl($acl)
    {
        $this->acl = $acl;
    }
}