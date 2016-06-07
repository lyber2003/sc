<?php
/**
 * @namespace
 */
namespace User\Service;

use User\Model\User as UserModel;
use Vein\Core\Acl\Service as Acl;

/**
 * Class Auth
 *
 * @category   Service
 * @package    Admin
 */
class Auth
{
    static public $SSL_CONFIG = [
        'digest_alg' => 'sha512',
        'private_key_bits' => 512,
        'private_key_type' => OPENSSL_KEYTYPE_RSA
    ];

    /**
     * Max accepted request delay time
     *
     * @var int
     */
    protected $_maxRequestDelay = 86400; //1 day

    /**
     * Id of the Client
     *
     * @var int
     */
    protected $_id;

    /**
     * Acl service
     *
     * @var \Vein\Core\Acl\Service
     */
    protected $_acl;

    /**
     * User model
     *
     * @var UserModel
     */
    protected $_userModel;

    /**
     * User login
     *
     * @var string
     */
    protected $_user;

    /**
     * User password
     *
     * @var string
     */
    protected $_password;

    /**
     * Token object
     *
     * @var \User\Service\Token
     */
    protected $_token;

    /**
     * Annotanio adapter
     *
     * @var \Phalcon\Annotations\AdapterInterface
     */
    protected $_annotations;

    /**
     * User private key
     *
     * @var string
     */
    protected $_privateKey;

    /**
     * User role
     *
     * @var string
     */
    protected $_role;

    /**
     * Constructor
     *
     * @param Acl       $acl
     * @param UserModel $userModel
     * @param string    $user
     * @param string    $password
     */
    public function __construct(Acl $acl, UserModel $userModel, $user = null, $password = 'password')
    {
        $this->_acl = $acl;
        $this->_userModel = $userModel;
        $this->_user = $user;
        $this->_password = $password;

        if (!$this->_initUser()) {

        }
    }

    /**
     * Initialize user
     *
     * @return boolean
     * @throws \Vein\Core\Exception
     */
    private function _initUser()
    {
        if (!$this->_user && !$this->_userModel->getId()) {
            return false;
        }
        
        if ($this->_userModel->getId()) {
            /* @var \User\Model\User $user */
            $user = $this->_userModel;
            $this->_user = $user->getLoginCredential();
        } else {
            //for password use password only for validation
            $user = $this->_userModel->findByCredentials(['login' => $this->_user, 'password' => $this->_password]);
            if (!$user) {
                return false;
            }
        }

        $this->_id = $user->getId();
        $pass = $user->getPasswordCredential();
        $this->_privateKey = ($pass) ? $pass : $this->_id;
        $this->_role = $user->core_acl_role_id;

        return true;
    }

    /**
     * Set token object
     *
     * @param \User\Service\Token $request
     *
     * @return \User\Service\Auth
     */
    public function setToken(\User\Service\Token $token)
    {
        $this->_token = $token;

        return $this;
    }

    /**
     * Set annotation adapter
     *
     * @param \Phalcon\Annotations\AdapterInterface $annatation
     *
     * @return \User\Service\Auth
     */
    public function setAnnotations(\Phalcon\Annotations\AdapterInterface $annotations)
    {
        $this->_annotations = $annotations;

        return $this;
    }

    /**
     * Check access user to admin modules
     *
     * @var string $module
     * @var string $controller
     * @var string $action
     *
     * @return bool
     */
    public function checkAdminAccess($module, $controller, $action)
    {
        if ($this->_acl->isAllowed($this->_userModel->getRole(), \Vein\Core\Acl\Dispatcher::ACL_ADMIN_MODULE, \Vein\Core\Acl\Dispatcher::ACL_ADMIN_CONTROLLER, '*')) {
            return true;
        }

        if ($this->_acl->isAllowed($this->_userModel->getRole(), \Vein\Core\Acl\Dispatcher::ACL_ADMIN_MODULE, \Vein\Core\Acl\Dispatcher::ACL_ADMIN_CONTROLLER, $action)) {
            return true;
        }

        if ($this->_acl->isAllowed($this->_userModel->getRole(), $module, $controller, $action, false)) {
            return true;
        }

        return false;
    }

    /**
     * Validate user by token
     *
     * @param string $token
     *
     * @return bool
     */
    public function authorize($token)
    {
        if (!$this->_token) {
            throw new \Exception('User token not set');
        }
        if (!$this->_id) {
            return false;
        }
        if (!$this->_privateKey) {
            return false;
        }

        if (!$this->_token->checkToken($token, $this->_user, $this->_privateKey)) {
            return false;
        }

        if ((time() - $this->_token->parseTimestamp($token)) >= $this->_maxRequestDelay) {
            return false;
        }

        return true;
    }

    /**
     * Check access to controllers action from annotation
     *
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     *
     * @return bool
     */
    public function checkAccessFromAnnotations(\Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $class = $dispatcher->getControllerClass();
        $actionName = $dispatcher->getActionName();
        $method = $actionName . "Action";
        //Parse the annotations in the method currently executed
        $annotations = $this->_annotations->getMethod($class, $method);
        if ($annotations->has('Access')) {
            //The method has the annotation 'Cache'
            $annotation = $annotations->get('Access');
            $argument = $annotation->getArgument(0);
            //Check if there is an user defined cache key
            if ($argument && $argument == 'allowed') {
                return true;
            }
            //Check if there is an user defined cache key
            if ($argument && $argument == 'denied') {
                return false;
            }
        }

        return false;
    }

    /**
     * Return user id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Return user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Return user
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->_userModel->name;
    }

    /**
     * Return user role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->_role;
    }

    /**
     * Find and return user private key
     *
     * @return boolean|string
     */
    public function getPrivateKey()
    {
        return $this->_privateKey;
    }

    /**
     * Generate token
     *
     * @return string
     */
    public function generateToken()
    {
        if (!$this->_token) {
            throw new \Exception('User token not set');
        }
        if (!$this->_id) {
            return false;
        }
        if (!$this->_privateKey) {
            return false;
        }

        return $this->_token->generate($this->_user, $this->_privateKey);
    }

    /**
     * Generate ssl private key
     *
     * @return string
     */
    public static function generatePrivateKey()
    {
        // Create the private and public key
        $res = openssl_pkey_new(self::$SSL_CONFIG);
        openssl_pkey_export($res, $privateKey);
        $privateKey = str_replace(['-----BEGIN PRIVATE KEY-----', '-----END PRIVATE KEY-----'], '', $privateKey);
        $privateKey = trim($privateKey);

        return $privateKey;
    }
}
