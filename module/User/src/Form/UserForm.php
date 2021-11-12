<?php
namespace User\Form;

use Laminas\Form\Form;

class UserForm extends Form
{

    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('User');
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'regDate',
            'type' => 'hidden'
        ]);
        $this->add([
            'name' => 'userName',
            'type' => 'text',
            'options' => [
                'label' => 'User Name'
            ]
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'Email'
            ]
        ]);
        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Password'
            ]
        ]);
        $this->add([
            'name' => 'conf_password',
            'type' => 'password',
            'options' => [
                'label' => 'Confirm Password'
            ]
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton'
            ]
        ]);
    }
}