<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\Files as Files;
use Application\Form\FilesForm as FilesForm;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        /* @var $objectManager \Doctrine\ORM\EntityManager */
        //$objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        // Получаем список всех 'файлов' и просто выводим его без отображениея view, чтобы понять, что происходит
        //$files = $objectManager->getRepository('\Application\Entity\Files')->findAll();
        //var_dump($files);
        //exit();

        $form = new FilesForm();

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function addAction()
    {

    }
}
