<?php
/**
 * @namespace
 */
namespace Core\Grid\Menu;

use Vein\Core\Crud\Grid,
    Vein\Core\Crud\Grid\Column,
    Vein\Core\Crud\Grid\Filter\Extjs as Filter,
    Vein\Core\Crud\Grid\Filter\Field,
    Vein\Core\Filter\SearchFilterInterface as Criteria;

/**
 * Class Menus
 *
 * @category    Module
 * @package     Menu
 * @subpackage  Grid
 */
class Menus extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'menu-menu';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Menu';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Menu\Menus';

    /**
     * Container condition
     * @var array|string
     */
    protected $_containerConditions = null;

    /**
     * Initialize grid columns
     *
     * @return void
     */
    protected function _initColumns()
    {
		$this->_columns = [
			'id'    => new Column\Primary('Id'),
			'name'   => new Column\Name('Name'),
			//'items' => new Column\JoinMany('Items', '\Core\Model\Menu\Item', null, null, ', ', 5)
		];
		//$this->_columns['item']->setAction('menu-item', 'menu');

        $this->addAdditional('grid', 'Core', 'MenuItem', 'menu');
    }

    /**
     * Initialize grid filters
     *
     * @return void
     */
    protected function _initFilters()
    {
        $this->_filter = new Filter([
    		'search' => new Field\Search('Search', 'search',
    			[
    				Criteria::COLUMN_ID => Criteria::CRITERIA_EQ,
    				Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
    				//'price_description' => Criteria::CRITERIA_BEGINS
    			]
		    ),
			'id' => new Field\Primary('Id')
        ]);
    }
}
