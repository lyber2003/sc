<?php
/**
 * @namespace
 */
namespace Generator\Service;

use Vein\Core\Mvc\Module\Service\AbstractService,
    Phalcon\CLI\Dispatcher,
    Phalcon\Events\Manager as EventsManager;

/**
 * Class Module
 *
 * @category   Service
 * @package    User
 */
class Module extends AbstractService
{
    /**
     * Initializes dispatcher
     */
    public function register()
    {
        $dependencyInjector = $this->getDi();
        $eventsManager = $this->getEventsManager();

        $config = $this->_config;

        $dependencyInjector->set('dispatcher', function() use ($dependencyInjector, $eventsManager, $config)  {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Generator\Task\\");

            return $dispatcher;
        });

        $this->_factory();
    }

    /**
     * Factory order services
     *
     * @return void
     */
    private function _factory()
    {
        $this->_factoryModelService();
        $this->_factoryGridService();
        $this->_factoryFormService();
        $this->_factoryService();
        $this->_factoryModuleService();
        $this->_factoryTestService();
    }

    /**
     * Initialize generator model service
     *
     * @return void
     */
    private function _factoryModelService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('generatorCreateModelService', [
            'className' => 'Generator\Service\Create\Model'
        ]);
    }

    /**
     * Initialize generator grid service
     *
     * @return void
     */
    private function _factoryGridService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('generatorCreateGridService', [
            'className' => 'Generator\Service\Create\Grid'
        ]);
    }

    /**
     * Initialize generator form service
     *
     * @return void
     */
    private function _factoryFormService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('generatorCreateFormService', [
            'className' => 'Generator\Service\Create\Form'
        ]);
    }

    /**
     * Initialize generator service
     *
     * @return void
     */
    private function _factoryService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('generatorCreateService', [
            'className' => 'Generator\Service\Create\Service'
        ]);
    }

    /**
     * Initialize generator module service
     *
     * @return void
     */
    private function _factoryModuleService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('generatorCreateModuleService', [
            'className' => 'Generator\Service\Create\Module'
        ]);
    }

    /**
     * Initialize generator test service
     *
     * @return void
     */
    private function _factoryTestService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('generatorCreateTestService', [
            'className' => 'Generator\Service\Create\Test'
        ]);
    }
} 