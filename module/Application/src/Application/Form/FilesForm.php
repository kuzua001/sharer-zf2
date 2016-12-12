<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 09.12.16
 * Time: 8:41
 */
namespace Application\Form;

use Zend\Form\Form;

class FilesForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('files-form');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));

        $this->add(array(
            'name' => 'protected',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Защитить паролем?',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Пароль',
            ),
        ));


        $this->add(array(
            'name' => 'file',
            'type' => 'File',
            'options' => array(
                'label' => 'Файл',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Сохранить',
                'id' => 'submitbutton',
                'class' => 'btn btn-default'
            ),
        ));
    }
}