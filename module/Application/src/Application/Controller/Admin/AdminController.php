<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Admin;

use Application\Form\AuthForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FilesForm as FilesForm;
use Application\Utils\AppHelper as AppHelper;

class AdminController extends AbstractActionController
{

    public function indexAction()
    {
        $form = new AuthForm();

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function addAction()
    {
    }
}
