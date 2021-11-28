<?php
namespace Application\Form;

use Laminas\Form\Form;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Checkbox;
use Laminas\Form\Element\Textarea;
use Laminas\Form\Element\Text;
use Laminas\Form\Element\Submit;
use Laminas\Form\Fieldset;
use Laminas\Mail\Header\Subject;
// use Application\Model\SettingsTable as Settings;
// use Laminas\Db\TableGateway\TableGateway;

/**
 *
 * @author Joey Smith
 *        
 */
class SettingsForm extends Form
{

    // TODO - Insert your code here
    
    /**
     */
    public function __construct($name, $options = [])
    {
        parent::__construct('appSettings');
        parent::setOptions($options);
        
        $appSettings = $this->getOptions();
        //var_dump($appSettings);
        // TODO - Insert your code here
        
//         $this->add([
//             'name' => 'password',
//             'type' => 'password',
//             'options' => [
//                 'label' => 'Password'
//             ]
//         ]);
        
        
        foreach($appSettings as $setting) {
            
            foreach ($setting as $data) {
                switch(strtolower($data['settingType'])) {
                    case 'checkbox' :
                                $element = new Checkbox();
                                $element->setName($data['variable']);
                                $element->setValue($data['value']);
                                $element->setLabel($data['label']);
                               // $element->setAttribute('class', 'form-control');
                                $element->setLabelAttributes(['class' => 'form-control-sm']);
                                //$element->setLabelOption('position', 'top');
                                $this->add($element);
                        break;
                    case 'text' :
                                $element = new Text();
                                $element->setName($data['variable']);
                                $element->setValue($data['value']);
                                $element->setLabel($data['label']);
                                $element->setAttribute('class', 'form-control');
                                //$element->setLabelAttributes(['class' => 'form-control']);
                                //$element->setOption('order', $data['id']);
                                $this->add($element);
                        break;
                    case 'textarea' :
                                $element = new Textarea();
                                $element->setName($data['variable']);
                                $element->setLabel($data['label']);
                                //$element->setLabelAttributes(['class' => 'form-control']);
                                $element->setValue($data['value']);
                                //$element->setOption('order', $data['id']);
                                $element->setAttribute('class', 'form-control');
                                $this->add($element);
                        break;
                    default:
                        break;
                }
                
                
                // continue;
            }
            
        }
//         $element = new Submit();
//         $element->setName('submit');
//         $element->setLabel('Save');
//         $element->setAttributes(['label' => 'Save', 'id' => 'submitbutton']);
//         $this->add($element);
//         $this->add([
//             'name' => 'submit',
//             'type' => 'submit',
//             'label' => 'Save',
//             'attributes' => [
//                 'value' => 'Save',
//                 'id' => 'submitbutton'
//             ]
//         ]);
    }
}

