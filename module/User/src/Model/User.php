<?php
namespace User\Model;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;
use Laminas\Validator\Db\NoRecordExists;
use User\Filter\PasswordFilter;
use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
use Laminas\Filter\StringToLower;
use Laminas\Validator\Identical;

class User implements RoleInterface, ResourceInterface, ProprietaryInterface
{
    protected $resourceId = 'user';
    public $id;
    public $userName;
    public $email;
    public $regDate;
    public $active;
    public $verified;
    public $password;
    public $role;
    public $dbAdapter;
    
    private $inputFilter;
    
    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->userName = !empty($data['userName']) ? $data['userName'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
       // $this->password  = null;
        $this->role  = !empty($data['role']) ? $data['role'] : null;
        $this->regDate = !empty($data['regDate']) ? $data['regDate'] : null;
        $this->active = !empty($data['active']) ? $data['active'] : null;
        $this->verified = !empty($data['verified']) ? $data['verified'] : null;
        return $this;
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
        return [
            'id'     => $this->id,
            'userName' => $this->userName,
            'email' => $this->email,
            'password'  => $this->password,
            'role' => $this->role,
            'regDate' => $this->regDate,
            'active' => $this->regDate,
            'verified' => $this->verified,
        ];
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

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
            ));
    }
    public function getLoginFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }
        
        $inputFilter = new InputFilter();
        
                $inputFilter->add([
                    'name' => 'email',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                    ],
                    'validators' => [
                        [
                            'name' => StringLength::class,
                            'options' => [
                                'encoding' => 'UTF-8',
                                'min' => 1,
                                'max' => 100,
                            ],
                        ],
                    ],
                ]);
                $inputFilter->add([
                    'name' => 'password',
                    'required' => true,
                    'filters' => [
                        ['name' => StripTags::class],
                        ['name' => StringTrim::class],
                    ],
                ]);
                $this->inputFilter = $inputFilter;
                return $this->inputFilter;
    }
    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }
        
        $inputFilter = new InputFilter();
        
        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'userName',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                    'name' => NoRecordExists::class,
                    'options' => [
                        'table' => $this->getResourceId(),
                        'field' => 'userName',
                        'dbAdapter' => $this->getDbAdapter(),
                    ],
                ],
                
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'email',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                    'name' => NoRecordExists::class,
                    'options' => [
                        'table' => $this->getResourceId(),
                        'field' => 'email',
                        'dbAdapter' => $this->getDbAdapter(),
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
                ['name' => PasswordFilter::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
            ],
        ]);
        
        $inputFilter->add([
            'name' => 'conf_password',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 100,
                    ],
                    'name' => Identical::class,
                    'options' => [
                        'token' => 'password',
                        'messages' => [
                            \Laminas\Validator\Identical::NOT_SAME => 'Passwords are not the same',
                        ],
                    ],
                ],
            ],
        ]);
                
        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
    /**
     * @return the $password
     */
    public function getPassword()
    {
        return $this->password;
    }
    
}
?>