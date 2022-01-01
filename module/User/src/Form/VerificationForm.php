<?php
namespace User\Form;

use \RuntimeException;
use Laminas\Form\Element\Hidden;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\Form\Fieldset;

class VerificationForm extends Form
{
    public function __construct($name, $options = null)
    {
        try {
            parent::__construct('VerificationForm');
            if(!empty($options)) {
                parent::setOptions($options);
            }
            
            
            
        } catch (RuntimeException $e) {
            
        }
        
    }
}