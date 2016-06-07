<?php
/**
 * @namespace
 */
namespace Frontend\Service;

use Vein\Core\Mvc\Module\Service\AbstractService;

/**
 * Class Module
 *
 * @category   Service
 * @package    Frontend
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
            'className' => 'Frontend\Service\ViewHelper',
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

        $dependencyInjector->set('frontendDispatcher', [
            'className' => 'Frontend\Service\Dispatcher',
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
        $dispatcher = $this->_di->get('frontendDispatcher');

        $eventsManager = $this->getEventsManager();
        $eventsManager->attach('dispatch', $dispatcher);
    }
}