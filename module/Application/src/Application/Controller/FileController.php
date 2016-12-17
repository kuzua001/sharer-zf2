<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 12.12.16
 * Time: 7:53
 */
namespace Application\Controller;

use Application\Form\DownloadForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Core\AppHelper as AppHelper;
use Application\Entity\Files as Files;

class FileController extends AbstractActionController
{
    public function indexAction()
    {
        $this->layout('layout/layout');
        $fileManager = AppHelper::fileManagerInstance();

        $link = $this->params('link');
        $file = $fileManager->getUploadedFile($link);
        if ($file !== false) {
            $form = new DownloadForm();
            $form->setData([
                'id' => $file->getId()
            ]);
            $form->setAttribute('action', $this->url()->fromRoute('files', array('action' => 'download', 'link' => $file->getLink())));
            $view = new ViewModel(['form' => $form, 'file' => $file]);

            if (!$file->getProtected()) {
                $view->setTemplate('application/file/download.phtml');
            } else {
                $view->setTemplate('application/file/download_protected.phtml');
            }
        } else {
            $view = new ViewModel();
            $view->setTemplate('application/file/empty.phtml');
        }

        return $view;
    }

    public function downloadAction()
    {
        $request = $this->getRequest();
        $post = $request->getPost();

        if (!isset($post['id'])) {
            return $this->redirect()->toRoute('index');
        }

        $fileManager = AppHelper::fileManagerInstance();
        $file = $fileManager->getFileById($post['id']);
        if ($file->getProtected() == 1) {
            if (md5($post['password'] . $file->getHash()) != $file->getPass()) {
                $form = new DownloadForm();
                $form->setData($post);
                $form->setAttribute('action', $this->url()->fromRoute('files', array('action' => 'download', 'link' => $file->getLink())));
                $view = new ViewModel(['form' => $form, 'file' => $file, 'failMessage' => 'неверный пароль']);
                $view->setTemplate('application/file/download_protected.phtml');

                // Не отдавать защищенный файл, если не подошел пароль
                return $view;
            }
        }

        $fileManager->increaseDownloadCount($file);

        return $this->getDownloadView($file);
    }

    private function getDownloadView($file)
    {
        if ($file !== false) {
            $filePath = AppHelper::fileManagerInstance()->getFullPath($file);
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