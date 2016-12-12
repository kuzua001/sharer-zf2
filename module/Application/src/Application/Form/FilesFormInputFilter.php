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
            'name' => 'file',
            'required' => true,
        ));
    }
}