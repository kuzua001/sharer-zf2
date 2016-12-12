<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Form\FilesFormInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FilesForm as FilesForm;
use Application\Utils\AppHelper as AppHelper;

class IndexController extends AbstractActionController
{
    const FILE_NAME = 'file';

    public function indexAction()
    {
        $form = new FilesForm();

        return new ViewModel([
            'form' => $form
        ]);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new FilesForm();
        $filter  = new FilesFormInputFilter();

        $post = array_merge_recursive(
            $request->getPost()->toArray(),
            $request->getFiles()->toArray()
        );
        if (!$post[self::FILE_NAME]['tmp_name']) {
            $post[self::FILE_NAME] = null;
        }

        $form->setInputFilter($filter);
        $form->setData($post);

        if ($form->isValid()) {
            $sl = $this->getServiceLocator();
            $filePath = $_FILES[self::FILE_NAME]['tmp_name'];
            $fileName = $_FILES[self::FILE_NAME]['name'];
            $fileType = $_FILES[self::FILE_NAME]['type'];
            $password = isset($_POST['protected']) && $_POST['protected'] ? $_POST['password'] : false;
            $savedFileInfo = AppHelper::saveUploadedFile($sl, $filePath, $password, $fileName, $fileType);

            return new ViewModel([
                'link' => $this->url()->fromRoute('files', array('link' => $savedFileInfo['link']))
            ]);
        } else {
            $view = new ViewModel([
                'form' => $form
            ]);
            $view->setTemplate('application/index/index.phtml');

            return $view;
        }
    }
}
