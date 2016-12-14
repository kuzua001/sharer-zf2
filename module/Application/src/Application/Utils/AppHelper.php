<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 11.12.16
 * Time: 21:22
 */

namespace Application\Utils;

use Symfony\Component\Console\Application;
use Zend\Di\ServiceLocatorInterface;
use Zend\Session\Container;

class AppHelper {
    const FILE_PASS_HASH_SOLT = 'ASFKG(SRVMFsv{SFsfgg1';

    /**
     * Генерирует случайный адрес ссылки на файл
     * @return sring|bool
     * @param $entityManager \Doctrine\ORM\EntityManager
     */
    private static function generateUniqFileLink($entityManager) {
        $link = '';

        try {
            $filesMaxId = $entityManager->createQueryBuilder()
                ->select('max(e.id)')
                ->from('\Application\Entity\Files', 'e')
                ->getQuery()
                ->getSingleScalarResult();

            $link = md5(self::FILE_PASS_HASH_SOLT . $filesMaxId);

            return $link;
        } catch (\Exception $ex) {

        }

        return false;
    }

    /**
     * Сохраняет загруженный файл и возвращает ссылку на него
     * @param $serviceLocator ServiceLocatorInterface
     * @param $fileName string имя временного файла
     * @return array|bool массив с ключами link и path, либо false в случае ошибки
     */
    public static function saveUploadedFile($serviceLocator, $filePath, $pass, $fileName, $fileType) {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $link = self::generateUniqFileLink($entityManager);

        /* Путь куда мы созраняем этот файл */
        $targetPath = getcwd() . $serviceLocator->get('config')['file_storage']['path'] . "/$link";

        try {
            if (move_uploaded_file($filePath, $targetPath)) {

                $file = new \Application\Entity\Files();
                $file->setFileName($fileName);
                $file->setFileType($fileType);
                $file->setLink($link);
                $file->setSize(filesize($targetPath));

                if ($pass !== false) {
                    /* Делаем соль из ссылки файла и некоторой фиксированной соли */
                    $salt     = md5($link . self::FILE_PASS_HASH_SOLT);
                    $passHash = md5($pass . $salt);
                    $file->setPass($passHash);
                    $file->setHash($salt);
                }

                $file->setProtected($pass !== false);
                $entityManager->persist($file);
                $entityManager->flush();

                return [
                    'link' => $link,
                    'path' => $targetPath,
                ];
            }
        } catch (\Exception $ex) {
            //todo add logging this issue
        }

        return false;
    }

    /**
     * Берет из базы данные файла, либо возвращает false
     * @param $serviceLocator
     * @param $link
     * @return array|bool
     */
    public static function getUploadedFile($serviceLocator, $link) {
        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $files = $entityManager->getRepository('Application\Entity\Files')->findBy(['link' => $link]);
        if (count($files)) {

            return $files[0];
        }

        return false;
    }

    /**
     * Берет из базы данные файла по id, либо возвращает false
     * @param $serviceLocator
     * @param $id
     * @return \Application\Entity\Files|bool
     */
    public static function getFileById($serviceLocator, $id) {
        /* @var $entityManager \Doctrine\ORM\EntityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $file = $entityManager->getRepository('Application\Entity\Files')->find($id);

        return $file;
    }


    /**
     * Авторизован ли пользователь
     * @return mixed
     */
    public static function isAuth() {
        $session = new Container('userarea');
        return $session->offsetExists('user_id');
    }

    /**
     * попытка авторизации
     * @param $serviceLocator
     * @param $name
     * @param $password
     * @return bool|Container
     */
    public static function login($serviceLocator, $name, $password) {
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $users = $entityManager->getRepository('Application\Entity\Users')->findBy(['name' => $name]);
        if (count($users) == 1) {
            $user = $users[0];
            if (md5($password . $user->getHash()) == $user->getPass()) {
                $session = new Container('userarea');
                $session->offsetSet('user_id', $user->getId());

                return $session;
            }
        }

        return false;
    }

    public static function logout() {
        $session = new Container('userarea');
        $session->offsetUnset('user_id');

        return true;
    }

    /**
     * Получить данные авторизованного пользователя
     * @return bool|Container
     */
    public static function getAuthUser() {
        $session = new Container('userarea');
        if ($session->offsetExists('user_id')) {
            return $session;
        }

        return false;
    }
};