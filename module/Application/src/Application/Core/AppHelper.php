<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 11.12.16
 * Time: 21:22
 */

namespace Application\Core;

use Zend\Di\ServiceLocatorInterface;
use Zend\ServiceManager\Exception\InvalidArgumentException;

class AppHelper {
    /**
     * Содержит объект, полученный для работы с различными сервисами (doctrine, config) и т.д.
     * На самом деле пока не очень понимаю концепцию паттерна Service Locator и не знаю как лучше его использовать
     * @var $serviceLocator ServiceLocatorInterface|null
     */
    private static $serviceLocator = null;

    /**
     * Инициализация хелпера, должна происходит в модуле приложения
     * @param $serviceLocator ServiceLocatorInterface
     */
    public static function init($serviceLocator) {
        self::$serviceLocator = $serviceLocator;
    }

    /**
     * Проверяет проинициализирован ли объект $serviceLocator
     * @throws InvalidArgumentException
     */
    private static function initCheck() {
        if (self::$serviceLocator === null) {
            throw new InvalidArgumentException('Не инициализирован объект ServiceLocator');
        }
    }

    /**
     * Инстанс менеджера пользователей
     * @param $userManager UserManager|null
     */
    private static $userManager = null;

    /**
     * Получить инстанс менеджера пользователей
     * @return UserManager|null
     */
    public static function userManagerInstance()
    {
        self::initCheck();

        if (self::$userManager == null) {
            $entityManager = self::$serviceLocator->get('Doctrine\ORM\EntityManager');
            self::$userManager = new UserManager($entityManager);
        }

        return self::$userManager;
    }

    /**
     * Инстанс файлового менеджера. (тут дублирование кода, но разных инстансов пока всего 2, поэтому на данном этапе
     * нет смысла реализовывать паттерн коллекци синглтонов (точное название не помню)
     * @param $fileManager FileManager|null
     */
    private static $fileManager = null;

    /**
     * Получить инстанс менеджера пользователей
     * @return FileManager|null
     */
    public static function fileManagerInstance()
    {
        self::initCheck();

        if (self::$fileManager == null) {
            $entityManager = self::$serviceLocator->get('Doctrine\ORM\EntityManager');
            self::$fileManager = new FileManager($entityManager);
        }

        return self::$fileManager;
    }

    /**
     * Возвращает конифг приложения
     * @return array|mixed
     */
    public static function getConfig()
    {
        self::initCheck();

        return self::$serviceLocator->get('config');
    }
};