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

        $serviceLocator = $this->getServiceLocator();
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $files = $entityManager->getRepository('Application\Entity\Files')->findAll();

        $view = new ViewModel([
            'form' => $form,
            'files' => $files,
        ]);
        $view->setTemplate('application/admin/admin/index.phtml');

        return $view;
    }

    public function loginAction()
    {
        $sl = $this->getServiceLocator();
        $request = $this->getRequest();
        $post = $request->getPost();

        if (AppHelper::login($sl, $post['login'], $post['password'])) {
            $view = $this->indexAction();
        } else {
            $form = new AuthForm();
            $form->setData($post);

            $view = new ViewModel([
                'form'        => $form,
                'failMessage' => 'Ошибка авторизации',
            ]);
            $view->setTemplate('application/admin/admin/index.phtml');
        }

        return $view;
    }

    public function logoutAction()
    {
        AppHelper::logout();
        return $this->indexAction();
    }
}
