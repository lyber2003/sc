<?php
/**
 * @namespace
 */
namespace Admin\Service;

/**
 * Class Dispatcher
 *
 * @category   Service
 * @package    Admin
 */
class Dispatcher
{
    /**
     * Service request object
     * @var \Phalcon\Service\Request
     */
    private $_request;

    /**
     * Service response object
     * @var \Phalcon\Service\Response
     */
    private $_response;

    /**
     * Service auth object
     * @var \User\Service\Auth
     */
    private $_auth;

    /**
     * Constructor
     *
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Http\Response $response
     * @param \User\Service\Auth $auth
     */
    public function __construct(
        \Phalcon\Http\Request $request = null,
        \Phalcon\Http\Response $response = null,
        \User\Service\Auth $auth = null
    ) {
        $this->_request = $request;
        $this->_response = $response;
        $this->_auth = $auth;
    }

    /**
     * Set service request object
     *
     * @param \Phalcon\Http\Request $request
     *
     * @return \Admin\Service\Dispatcher
     */
    public function setRequest(\Phalcon\Http\Request $request)
    {
        $this->_request = $request;
        return $this;
    }

    /**
     * Set service response object
     *
     * @param \Phalcon\Http\Response $response
     *
     * @return \Admin\Service\Dispatcher
     */
    public function setResponse(\Phalcon\Http\Response $response)
    {
        $this->_response = $response;
        return $this;
    }

    /**
     * Set service request object
     *
     * @param \User\Service\Request $request
     *
     * @return \Admin\Service\Dispatcher
     */
    public function setAuth(\User\Service\Auth $auth)
    {
        $this->_auth = $auth;
        return $this;
    }

    /**
     * Triggered before entering in the dispatch loop.
     * At this point the dispatcher don’t know if the controller or the actions to be executed exist.
     * The Dispatcher only knows the information passed by the Router.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeExecuteRoute(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {
        if ($this->_auth->checkAccessFromAnnotations($dispatcher)) {
            return true;
        }
        if (!$this->_auth->getId()) {
            // User is not authenticated, access should be denied.
            if ($this->_request->isAjax()) {
                $this->_response->redirect('/denied');
                /*$dispatcher->forward([
                    "controller" => 'admin',
                    "action"     => 'denied'
                ]);*/
            } else {
                $this->_response->redirect('/login');
                /*$dispatcher->forward([
                    "controller" => 'admin',
                    "action"     => 'login'
                ]);*/
            }
            return true;
        }

        $module= $dispatcher->getModuleName();
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        if (!$this->_auth->checkAdminAccess($module, $controller, $action)) {
            // User is not authenticated, access should be denied.
            if ($dispatcher->request->isAjax()) {
                $this->_response->redirect('/denied');
                /*$dispatcher->forward([
                    "controller" => 'admin',
                    "action"     => 'denied'
                ]);*/
            } else {
                $this->_response->redirect('/login');
                /*$dispatcher->forward([
                    "controller" => 'admin',
                    "action"     => 'login'
                ]);*/
            }
            return true;
        }

        return true;
    }

    /**
     * Triggered after entering in the dispatch loop.
     * At this point the dispatcher don’t know if the controller or the actions to be executed exist.
     * The Dispatcher only knows the information passed by the Router.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeDispatch(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher)
    {

    }

    /**
     * Triggered before the dispatcher throws any exception
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Dispatcher $dispatcher
     * @param \Exception $exception
     * @return boolean
     */
    public function beforeException(\Phalcon\Events\Event $event, \Phalcon\Mvc\Dispatcher $dispatcher, \Exception $exception)
    {
        //$dispatcher->setReturnedValue($this->_response->getResponse());

        return true;
    }
}