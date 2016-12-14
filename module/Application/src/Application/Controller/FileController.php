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
use Application\Utils\AppHelper as AppHelper;

class FileController extends AbstractActionController
{
    public function indexAction() {
        $this->layout('layout/layout');

        $link = $this->params('link');
        $sl = $this->getServiceLocator();
        $file = AppHelper::getUploadedFile($sl, $link);
        if ($file !== false) {
            $form = new DownloadForm();
            $form->setData([
                'id' => $file->getId()
            ]);
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

    public function downloadAction() {
        $sl = $this->getServiceLocator();
        $request = $this->getRequest();
        $post = $request->getPost();

        if (!isset($post['id'])) {
            return $this->redirect()->toRoute('index');
        }

        $file = AppHelper::getFileById($sl, $post['id']);
        if ($file->getProtected() == 1) {
            if (md5($post['password'] . $file->getHash()) != $file->getPass()) {
                $form = new DownloadForm();
                $form->setData($post);
                $view = new ViewModel(['form' => $form, 'file' => $file, 'failMessage' => 'неверный пароль']);
                $view->setTemplate('application/file/download_protected.phtml');

                // Не отдавать защищенный файл, если не подошел пароль
                return $view;
            }
        }

        // Увеличиваем счетчик скачиваний на единицу
        // todo: вынести в отдельный метод класса Files, либо сделать класс FileManager, который
        // todo: инициализирует EntityManager и инкапсулирует весь функцонал по файлам
        $downloadCount = $file->getDownloadCount();
        $file->setDownloadCount($downloadCount + 1);
        $entityManager = $sl->get('\Doctrine\ORM\EntityManager');
        $entityManager->persist($file);
        $entityManager->flush();

        $view = $this->download($file);

        return $view;
    }

    private function download($file) {
        if ($file !== false) {
            $sl = $this->getServiceLocator();
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