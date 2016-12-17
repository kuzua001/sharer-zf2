<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 17.12.16
 * Time: 13:15
 */

namespace Application\Core;

use Doctrine\ORM\EntityManager as EntityManager;
use Application\Entity\Files as Files;

/**
 * Позволяет осуществлять работу с файлами
 * Class FileManager
 * @package Application\Core
 */
class FileManager
{
    const FILES_CONFIG_KEY = 'file_storage';
    const FILE_PASS_HASH_SOLT = 'ASFKG(SRVMFsv{SFsfgg1';

    private $filesRepository = null;
    private $entityManager = null;
    private $configData = [];

    /**
     * FileManager constructor.
     * @param $entityManager EntityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->filesRepository = $entityManager->getRepository('Application\Entity\Files');
        $this->configData = AppHelper::getConfig()[self::FILES_CONFIG_KEY];
    }

    /**
     * Возвращает путь хранения файлов
     * @return mixed
     */
    public function getFileStoragePath()
    {
        return $this->configData['path'];
    }

    /**
     * Генерирует случайный адрес ссылки на файл
     * @return string|bool
     * @param $entityManager \Doctrine\ORM\EntityManager
     */
    private function generateUniqFileLink()
    {
        $link = '';

        try {
            $filesMaxId = $this->entityManager->createQueryBuilder()
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
     * @param $fileName string имя временного файла
     * @return array|bool массив с ключами link и path, либо false в случае ошибки
     */
    public function saveUploadedFile($filePath, $pass, $fileName, $fileType)
    {
        $link = $this->generateUniqFileLink();

        /* Путь куда мы созраняем этот файл */
        $targetPath = getcwd() . $this->getFileStoragePath() . "/$link";

        try {
            if (move_uploaded_file($filePath, $targetPath)) {

                $file = new Files();
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
                $this->entityManager->persist($file);
                $this->entityManager->flush();

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
     * @param $link
     * @return \Application\Entity\Files|bool
     */
    public function getUploadedFile($link)
    {
        $files = $this->filesRepository->findBy(['link' => $link]);
        if (count($files)) {

            return $files[0];
        }

        return false;
    }

    /**
     * Берет из базы данные файла по id, либо возвращает false
     * @param $id
     * @return \Application\Entity\Files|bool
     */
    public function getFileById($id)
    {
        $file = $this->filesRepository->find($id);

        return $file;
    }

    /**
     * Полчить весь список файлов
     * @return array
     */
    public function findAll()
    {
        return $this->filesRepository->findAll();
    }

    /**
     * Получить полный путь к файлу
     * @param $file \Application\Entity\Files
     * @return string
     */
    public function getFullPath($file) {
        return getcwd() . $this->getFileStoragePath() . "/" . $file->getLink();
    }

    /**
     * Увеличить на 1 счетчик скачиваний файла
     * @param $file \Application\Entity\Files
     * @return string
     */
    public function increaseDownloadCount($file)
    {
        $downloadCount = $file->getDownloadCount();
        $file->setDownloadCount($downloadCount + 1);
        $this->entityManager->persist($file);
        $this->entityManager->flush();
    }
}