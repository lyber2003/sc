<?php
/**
 * @namespace
 */
namespace Core\Service;

use Vein\Core\Mvc\Module\Service\AbstractService;

/**
 * Class Module
 *
 * @category   Service
 * @package    Core
 */
class Module extends AbstractService
{
    /**
     * Initialize core auth
     *
     * @return void
     */
    public function register()
    {
        $this->_factory();
    }

    /**
     * Initialize core services
     *
     * @return void
     */
    private function _factory()
    {
        $this->_factoryMenuService();
        $this->_factoryMenuModel();
        $this->_factoryMenuForm();
        $this->_factoryMenuGrid();
        $this->_factoryItemModel();
        $this->_factoryItemForm();
        $this->_factoryItemGrid();
    }

    /**
     * Initialize core menu model
     *
     * @return void
     */
    private function _factoryMenuModel()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreMenuModel', [
            'className' => 'Core\Model\Menu\Menus'
        ]);
    }

    /**
     * Initialize core menu form
     *
     * @return void
     */
    private function _factoryMenuForm()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreMenuForm', [
            'className' => 'Core\Form\Menu\Menus'
        ]);
    }

    /**
     * Initialize core menu grid
     *
     * @return void
     */
    private function _factoryMenuGrid()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreMenuGrid', [
            'className' => 'Core\Grid\Menu\Menus'
        ]);
    }

    /**
     * Initialize core menu item model
     *
     * @return void
     */
    private function _factoryItemModel()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreItemModel', [
            'className' => 'Core\Model\Menu\Item'
        ]);
    }

    /**
     * Initialize core menu item form
     *
     * @return void
     */
    private function _factoryItemForm()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreItemForm', [
            'className' => 'Core\Form\Menu\Item'
        ]);
    }

    /**
     * Initialize core menu item grid
     *
     * @return void
     */
    private function _factoryItemGrid()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreItemGrid', [
            'className' => 'Core\Grid\Menu\Item'
        ]);
    }

    /**
     * Initialize core service
     *
     * @return void
     */
    private function _factoryMenuService()
    {
        $dependencyInjector = $this->getDi();

        $dependencyInjector->set('coreMenuService', [
            'className' => 'Core\Service\Menu'
        ]);
    }
}