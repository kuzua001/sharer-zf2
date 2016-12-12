<?php

namespace Application\Entity;
use Zend\Di\ServiceLocatorInterface;

/**
 * Files
 */
class Files
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $link;

    /**
     * @var boolean
     */
    private $protected = '0';

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $hash;

    /**
     * Получить полный путь к файлу
     * @param $serviceLocator ServiceLocatorInterface
     * @return string
     */
    public function getFullPath($serviceLocator) {
        return getcwd() . $serviceLocator->get('config')['file_storage']['path'] . "/{$this->link}";
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Files
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Files
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set protected
     *
     * @param boolean $protected
     *
     * @return Files
     */
    public function setProtected($protected)
    {
        $this->protected = $protected;

        return $this;
    }

    /**
     * Get protected
        *
     * @return boolean
     */
    public function getProtected()
    {
        return $this->protected;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return Files
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return Files
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
    /**
     * @var string
     */
    private $fileType;


    /**
     * Set fileType
     *
     * @param string $fileType
     *
     * @return Files
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }
}
