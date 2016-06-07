<?php
/**
 * @namespace
 */
namespace Core\Traits\Service;

use Core\Service\Menu as MenuService;

/**
 * Trait Menu
 *
 * @category   Service
 * @package    Menu
 * @subpackage Traits
 */
trait Menu
{
    /**
     * Menu service
     * @var MenuService
     */
    private $_menuService;

    /**
     * Set menu service
     *
     * @param MenuService $menuService
     *
     * @return mixed
     */
    public function setMenuService(MenuService $menuService)
    {
        $this->_menuService = $menuService;
        return $this;
    }

    /**
     * Return menu service object
     *
     * @return MenuService
     * @throws \Engine\Exception
     */
    public function getMenuService()
    {
        if (null === $this->_menuService) {
            if ($this->_di) {
                $this->_menuService = $this->_di->get('coreMenuService');
            }
        }
        if (!$this->_menuService instanceof MenuService) {
            throw new \Engine\Exception('Object not instance of Core\Service\Menu');
        }
        return $this->_menuService;
    }
}