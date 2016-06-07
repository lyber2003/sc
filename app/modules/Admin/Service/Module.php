<?php
/**
 * @namespace
 */
namespace Admin\Service;

use Vein\Core\Mvc\Module\Service\AbstractService;

/**
 * Class Module
 *
 * @category   Service
 * @package    Admin
 */
class Module extends AbstractService
{
    /**
     * Initialize API
     *
     * @return void
     */
    public function register()
    {
        $this->_factory();
    }

    /**
     * Initialize frontend services
     *
     * @return void
     */
    private function _factory()
    {
        $this->_factoryViewHelper();
        $this->_factoryDispatcher();
        $this->_initDispatcher();
    }

    /**
     * Initialize ViewHelper service
     *
     * @return void
     */
    private function _factoryViewHelper()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('viewHelper', [
            'className' => 'Admin\Service\ViewHelper',
            'arguments' => [
                ['type' => 'service', 'name' => 'view']
            ]
        ]);
    }

    /**
     * Initialize dispatcher service
     *
     * @return void
     */
    private function _factoryDispatcher()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('adminDispatcher', [
            'className' => 'Admin\Service\Dispatcher',
            'calls' => [
                [
                    'method'    => 'setAuth',
                    'arguments' => [
                        [
                            'type' => 'service',
                            'name' => 'userAuth'
                        ]
                    ]
                ],
                [
                    'method'    => 'setRequest',
                    'arguments' => [
                        [
                            'type' => 'service',
                            'name' => 'request'
                        ]
                    ]
                ],
                [
                    'method'    => 'setResponse',
                    'arguments' => [
                        [
                            'type' => 'service',
                            'name' => 'response'
                        ]
                    ]
                ]
            ]
        ]);
    }

    /**
     * Initialize dispatcher
     */
    private function _initDispatcher()
    {
        $dispatcher = $this->_di->get('adminDispatcher');

        $eventsManager = $this->getEventsManager();
        $eventsManager->attach('dispatch', $dispatcher);
    }
}