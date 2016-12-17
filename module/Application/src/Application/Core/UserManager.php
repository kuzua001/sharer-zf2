<?php
/**
 * Created by PhpStorm.
 * User: paul-simon
 * Date: 17.12.16
 * Time: 12:48
 */

namespace Application\Core;

use Doctrine\ORM\EntityManager as EntityManager;
use Zend\Session\Container as Container;
use Application\Entity\Users as Users;

/**
 * Позволяет осуществлять авторизацию, выход и проверку авторизации пользователей
 * Class UserManager
 * @package Application\Core
 */
class UserManager
{
    private $usersRepository = null;
    private $user = null;
    private $userSession;

    const USER_ID_KEY = 'user_id';
    const USER_SESSION_CONTAINER_KEY = 'userarea';

    /**
     * UserManager constructor.
     * @param $entityManager EntityManager
     */
    public function __construct($entityManager)
    {
        $this->usersRepository = $entityManager->getRepository('Application\Entity\Users');
        $this->userSession = new Container(self::USER_SESSION_CONTAINER_KEY);
        if ($this->userSession->offsetExists(self::USER_ID_KEY)) {

            return $this->user = $this->userSession;
        }
    }

    /**
     * Авторизован ли пользователь
     * @return mixed
     */
    public function isAuth()
    {
        return $this->user !== null;
    }

    /**
     * Попытка авторизации
     * @param $name
     * @param $password
     * @return bool|Container
     */
    public function login($name, $password)
    {
        $users = $this->usersRepository->findBy(['name' => $name]);
        if (count($users) == 1) {
            /* @var $user Users */
            $user = $users[0];
            if (md5($password . $user->getHash()) == $user->getPass()) {
                $this->userSession->offsetSet(self::USER_ID_KEY, $user->getId());
                $this->user = $this->userSession;

                return $this->getUser();
            }
        }

        return false;
    }

    /**
     * Выход из пользовательской сессии
     * @return bool
     */
    public function logout()
    {
        $this->userSession->offsetUnset(self::USER_ID_KEY);
        $this->user = null;

        return true;
    }

    /**
     * Получить данные авторизованного пользователя
     * @return null|Container
     */
    public function getUser()
    {
        return $this->user;
    }
}