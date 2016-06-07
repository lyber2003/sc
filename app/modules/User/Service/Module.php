<?php
/**
 * @namespace
 */
namespace User\Service;

use Vein\Core\Mvc\Module\Service\AbstractService,
    User\Service\Auth as UserAuth,
    User\Service\Token as UserToken;

/**
 * Class Module
 *
 * @category   Service
 * @package    User
 */
class Module extends AbstractService
{
    /**
     * Initialize user auth
     *
     * @return void
     */
    public function register()
    {
        $this->_factory();
    }

    /**
     * Initialize user services
     *
     * @return void
     */
    private function _factory()
    {
        $this->_factoryUserModel();
        $this->_factoryUserService();
        $this->_factoryToken();
        $this->_factoryAuth();
        $this->_factoryUserFormLogin();
    }

    /**
     * Initialize user request service
     *
     * @return void
     */
    private function _factoryRequest()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('userRequest', [
            'className' => 'User\Service\Request',
            'calls' => [
                [
                    'method'    => 'setRequest',
                    'arguments' => [
                        [
                            'type' => 'service',
                            'name' => 'request'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * Initialize user token service
     *
     * @return void
     */
    private function _factoryToken()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('userToken', [
            'className' => 'User\Service\Token'
        ]);
    }

    /**
     * Initialize user model
     *
     * @return void
     */
    private function _factoryUserModel()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('userModel', [
            'className' => 'User\Model\User'
        ]);
    }

    /**
     * Initialize user login form
     *
     * @return void
     */
    private function _factoryUserFormLogin()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('userFormLogin', [
            'className' => 'User\Form\Login'
        ]);
    }

    /**
     * Initialize user service
     *
     * @return void
     */
    private function _factoryUserService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('userService', [
            'className' => 'User\Service\User',
            'arguments' => [
                ['type' => 'service', 'name' => 'userModel']
            ]
        ]);
    }

    /**
     * Initialize user authorize service
     *
     * @return void
     */
    private function _factoryAuth()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('userAuth', function() use ($dependencyInjector) {
            /* @var \Vein\Core\Session\Adapter\Redis $session */
            $session = $dependencyInjector->get('session');
            /* @var \Vein\Core\Acl\Authorizer $auth */
            $auth = $dependencyInjector->get('auth');
            if (!$auth->isAuth() && $userId = $session->get('id')) {
                $auth->authUserById($userId);
            }

            if ($auth->isAuth()) {
                $userModel = $auth->getUser();
            } else {
                $userModel = $dependencyInjector->get('userModel');
            }

            $acl = $dependencyInjector->get('acl');
            $userToken = $dependencyInjector->get('userToken');

            $user = null;
            $auth = new UserAuth($acl, $userModel, $user);
            $auth->setToken($userToken);

            $annotations = $dependencyInjector->get('annotations');
            $auth->setAnnotations($annotations);

            return $auth;
        });
    }
}