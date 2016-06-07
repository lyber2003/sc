<?php
/**
 * @namespace
 */
namespace User\Service;

use Phalcon\DI\InjectionAwareInterface,
    Phalcon\Db\RawValue,
    Vein\Core\Tools\Traits\DIaware,

    User\Model\User as UserModel,
    Vein\Core\Tools\Arrays,

    Vein\Core\Cache\Traits\Cacher;

/**
 * Class User
 *
 * @category   Service
 * @package    User
 */
class User implements InjectionAwareInterface
{
    use DIaware,
        Cacher;

    /**
     * User model
     *
     * @var UserModel
     */
    private $_userModel;

    /**
     * User to artist model
     *
     * @var UserArtistModel
     */
    private $_userArtistModel;

    /**
     * Constructor
     *
     * @param UserModel       $userModel
     */
    public function __construct(
        UserModel $userModel
    ) {
        $this->_userModel = $userModel;
    }

    /**
     * Find and return User by id
     *
     * @param integer $userId
     * @param boolean $returnObject
     *
     * @return array
     * @throws \Vein\Core\Exception
     */
    public function get($userId, $returnObject = false)
    {
        $result = $this->_userModel->findFirst($userId);

        if (!$result) {
            throw new \Vein\Core\Exception('User with id \'' . $userId . '\' not found');
        }
        if ($returnObject) {
            return $result;
        }

        return $result->toArray();
    }

    /**
     * Update previous logged in
     *
     * @param integer $userId
     *
     * @return bool
     */
    public function updatePreviousLoggedIn($userId)
    {
        $user = $this->_userModel->findFirst($userId);

        $user->prev_logged_in_at = $user->logged_in_at;
        $user->logged_in_at = date('Y-m-d H:i:s');

        return $user->save();
    }

    public function loginUser(){
        return 'something';
    }

    public function save(){
        return true;
    }

    public function assign(){
        return true;
    }


    /**
     * Validate email for registration
     *
     * @param string $email
     *
     * @return array
     */
    private function _validateEmail($email)
    {
        $emailErrors = [];

        $regex = "/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        if (!preg_match($regex, $email)) {
            $emailErrors[] = 'Please enter a valid email';
        }

        $user = $this->_userModel->findFirst(["email = '$email'"]);
        if ($user) {
            $emailErrors[] = 'A user with this email already exists';
        }

        return $emailErrors;
    }

    /**
     * Validate password for registration
     *
     * @param string $password
     *
     * @return array
     */
    private function _validatePassword($password)
    {
        $passwordErrors = [];

        if (strlen($password) < 3) {
            $passwordErrors[] = 'Password is too short (minimum 3 characters)';
        }

        return $passwordErrors;
    }

    /**
     * Validate password
     *
     * @param     string  $password
     * @param      string $hash
     * @param null        $record
     *
     * @return bool
     */
    protected function _checkPassword($password, $hash, $record = null)
    {
        // for users logged in by md5 alg.
        if (substr($hash, 0, 4) != '$2a$' && md5($password) == $hash && $record) {
            // rehash password by Blowfish alg.
            $record->password = self::cryptPassword($password);
            $record->save();

            return true;
        }

        return crypt($password, $hash) == $hash;
    }

    /**
     * Crypt password
     *
     * @param string $password
     * @param int    $cost
     *
     * @return string
     */
    public static function blowfishCrypt($password, $cost = 10)
    {
        $chars = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $salt = sprintf('$2a$%02d$', $cost);

        for ($i = 0; $i < 22; $i++) {
            $salt .= $chars[rand(0, 63)];
        }

        return crypt($password, $salt);
    }

    /**
     * Generate email confirmation key
     *
     * @param string $email
     *
     * @param string $redirectUrl
     *
     * @return string
     */
    public static function generateEmailConfirmKey($email, $redirectUrl)
    {
        $keyObject = [
            'key' => md5(microtime() . $email),
            'email' => $email,
            'redirectUrl' => $redirectUrl != null ? $redirectUrl : false
        ];

        return base64_encode(json_encode($keyObject));
    }

    /**
     * Generate active key
     *
     * @param string $email
     *
     * @return string mixed
     */
    public static function generateActiveKey($email)
    {
        return md5(microtime() . $email);
    }

    /**
     * Change user_role of userwith $userId to $role
     *
     * @param $userId
     * @param $role
     *
     * @return mixed
     */
    public function changeUserRole($userId, $role)
    {
        $user = $this->_userModel->findFirst(["id = '$userId'"]);

        $user->user_role = $role;

        if ($user->save(false)) {
            $result['success'] = true;
        } else {
            throw new \Vein\Core\Exception('Error while changing user role = ' . $user->getMessages()[0]);
            $result['success'] = false;
        }

        return $result;
    }

}
