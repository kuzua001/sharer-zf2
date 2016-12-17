<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\AuthForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FilesForm as FilesForm;
use Application\Core\AppHelper as AppHelper;

class AdminController extends AbstractActionController
{

    public function indexAction()
    {
        if (!AppHelper::userManagerInstance()->isAuth()) {
            return $this->redirect()->toRoute('admin', [
                'action' => 'login'
            ]);
        }

        $form = new AuthForm();
        $files = AppHelper::fileManagerInstance()->findAll();

        $view = new ViewModel([
            'form' => $form,
            'filesProvider' => $files,
        ]);
        $view->setTemplate('application/admin/index.phtml');

        return $view;
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();
        $userManager = AppHelper::userManagerInstance();
        $authAttempt = isset($post['login']) && isset($post['password']);

        if ($userManager->isAuth() || ($authAttempt && $userManager->login($post['login'], $post['password']))) {

            return $this->redirect()->toRoute('admin', [
                'action' => 'index'
            ]);
        } else {
            $form = new AuthForm();
            $form->setAttribute('action', $this->url()->fromRoute('admin', ['action' => 'login']));
            $form->setData($post);

            $view = new ViewModel([
                'form'        => $form,
                'failMessage' => $authAttempt ? 'Ошибка авторизации' : null,
            ]);
            $view->setTemplate('application/admin/login.phtml');
        }

        return $view;
    }

    public function logoutAction()
    {
        AppHelper::userManagerInstance()->logout();
        return $this->indexAction();
    }
}