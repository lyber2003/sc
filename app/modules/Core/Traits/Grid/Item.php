<?php
/**
 * @namespace
 */
namespace Core\Traits\Grid;

use Core\Grid\Menu\Item as CoreItemGrid;

/**
 * Trait Item
 *
 * @category   Grid
 * @package    Item
 * @subpackage Traits
 */
trait Item
{
    /**
     * Item service
     * @var CoreItemGrid
     */
    private $_coreItemGrid;

    /**
     * Set core promocode grid
     *
     * @param CoreItemGrid $coreItemGrid
     *
     * @return mixed
     */
    public function setCoreItemGrid(CoreItemGrid $coreItemGrid)
    {
        $this->_coreItemGrid = $coreItemGrid;
        return $this;
    }

    /**
     * Return core promocode grid object
     *
     * @return CoreItemGrid
     * @throws \Engine\Exception
     */
    public function getCoreItemGrid()
    {
        if (null === $this->_coreItemGrid) {
            if ($this->_di) {
                $this->_coreItemGrid = $this->_di->get('coreItemGrid');
            }
        }
        if (!$this->_coreItemGrid instanceof CoreItemGrid) {
            throw new \Engine\Exception('Object not instance of Core\Grid\Menu\Item');
        }
        return $this->_coreItemGrid;
    }
}