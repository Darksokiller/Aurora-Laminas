<?php
namespace User\Model;
use DomainException;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\Filter\ToInt;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\StringLength;
use User\Filter\PasswordFilter;
class Users
{
    public $id;
    public $name;
    public $email;
    public $regDate;
    public $active;
    public $verified;
    public $password;
    
    private $inputFilter;
    
    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->email = !empty($data['email']) ? $data['email'] : null;
        $this->password  = !empty($data['password']) ? $data['password'] : null;
        //$this->loginpassword  = !empty($data['loginpassword']) ? $data['loginpassword'] : null;
        $this->regDate = !empty($data['regDate']) ? $data['regDate'] : null;
        $this->active = !empty($data['active']) ? $data['active'] : null;
        $this->verified = !empty($data['verified']) ? $data['verified'] : null;
    }
    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password'  => $this->password,
            //'loginpassword'  => $this->loginpassword,
            'regDate' => $this->regDate,
            'active' => $this->regDate,
            'verified' => $this->verified,
        ];
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
            'name' => 'name',
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