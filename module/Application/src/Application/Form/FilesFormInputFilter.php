<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 09.12.16
 * Time: 8:41
 */
namespace Application\Form;

use Zend\InputFilter\InputFilter;

class FilesFormInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'title',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 3,
                        'max' => 100,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        $this->add(array(
            'name' => 'text',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 50,
                    ),
                ),
            ),
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        ));
        $this->add(array(
            'name' => 'state',
            'required' => false,
        ));
    }
}