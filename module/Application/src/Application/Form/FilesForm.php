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
        // we want to ignore the name passed
        parent::__construct('file');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
            'options' => array(
                'label' => 'Название',
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
            ),
        ));
    }
}