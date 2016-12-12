<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 09.12.16
 * Time: 8:41
 */
namespace Application\Form;

use Zend\Form\Form;

class DownloadForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('download-form');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        //$this->setAttribute('target', '_blank');

        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Пароль',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Скачать',
                'id' => 'submitbutton',
                'class' => 'btn btn-default'
            ),
        ));
    }
}