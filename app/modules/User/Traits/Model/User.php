<?php
/**
 * @namespace
 */
namespace User\Traits\Model;

use User\Model\User as UserModel;

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
     * User model
     * @var UserModel
     */
    private $_userModel;

    /**
     * Set user model
     *
     * @param UserModel $userModel
     *
     * @return mixed
     */
    public function setUserModel(UserModel $userModel)
    {
        $this->_userModel = $userModel;
        return $this;
    }

    /**
     * Return user model object
     *
     * @return UserModel
     * @throws \Vein\Core\Exception
     */
    public function getUserModel()
    {
        if (null === $this->_userModel) {
            if ($this->_di) {
                $this->_userModel = $this->_di->get('userModel');
            }
        }
        if (!$this->_userModel instanceof UserModel) {
            throw new \Vein\Core\Exception('Object not instance of User\Model\User');
        }
        return $this->_userModel;
    }
}