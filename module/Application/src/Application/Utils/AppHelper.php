<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 11.12.16
 * Time: 21:22
 */

namespace Application\Utils;

use Zend\Di\ServiceLocatorInterface;

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
};