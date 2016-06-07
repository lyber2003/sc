<?php
/**
 * @namespace
 */
namespace User\Traits\Service;

use User\Service\User as UserService;

/**
 * Trait User
 *
 * @category   Service
 * @package    User
 * @subpackage Traits
 */
trait User
{
    /**
     * User service
     * @var UserService
     */
    private $_userService;

    /**
     * Set user service
     *
     * @param UserService $userService
     *
     * @return mixed
     */
    public function setUserService(UserService $userService)
    {
        $this->_userService = $userService;
        return $this;
    }

    /**
     * Return user service object
     *
     * @return UserService
     * @throws \Vein\Core\Exception
     */
    public function getUserService()
    {
        if (null === $this->_userService) {
            if ($this->_di) {
                $this->_userService = $this->_di->get('userService');
            }
        }
        if (!$this->_userService instanceof UserService) {
            throw new \Vein\Core\Exception('Object not instance of User\Service\User');
        }
        return $this->_userService;
    }
}