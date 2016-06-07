<?php
/**
 * @namespace
 */
namespace Core\Traits\Grid;

use Core\Grid\Menu\Menus as CoreMenuGrid;

/**
 * Trait Menu
 *
 * @category   Grid
 * @package    Menu
 * @subpackage Traits
 */
trait Menu
{
    /**
     * Menu service
     * @var CoreMenuGrid
     */
    private $_coreMenuGrid;

    /**
     * Set core promocode grid
     *
     * @param CoreMenuGrid $coreMenuGrid
     *
     * @return mixed
     */
    public function setCoreMenuGrid(CoreMenuGrid $coreMenuGrid)
    {
        $this->_coreMenuGrid = $coreMenuGrid;
        return $this;
    }

    /**
     * Return core promocode grid object
     *
     * @return CoreMenuGrid
     * @throws \Engine\Exception
     */
    public function getCoreMenuGrid()
    {
        if (null === $this->_coreMenuGrid) {
            if ($this->_di) {
                $this->_coreMenuGrid = $this->_di->get('coreMenuGrid');
            }
        }
        if (!$this->_coreMenuGrid instanceof CoreMenuGrid) {
            throw new \Engine\Exception('Object not instance of Core\Grid\Menu\Menus');
        }
        return $this->_coreMenuGrid;
    }
}