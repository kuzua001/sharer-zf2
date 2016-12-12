<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 12.12.16
 * Time: 7:53
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Utils\AppHelper as AppHelper;

class FileController extends AbstractActionController
{
    public function indexAction() {
        $link = $this->params('link');
        $sl = $this->getServiceLocator();
        $file = AppHelper::getUploadedFile($sl, $link);
        if ($file !== false) {
            $filePath = $file->getFullPath($sl);
            $view = new ViewModel([
                'file'     => $file,
                'filePath' => $filePath
            ]);
            $view->setTemplate('application/file/file.phtml');
        } else {
            $view = new ViewModel();
            $view->setTemplate('application/file/empty.phtml');
        }

        return $view;
    }
}