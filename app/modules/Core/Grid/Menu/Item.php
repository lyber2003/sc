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
 * Class Item
 *
 * @category    Module
 * @package     Menu
 * @subpackage  Grid
 */
class Item extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'menu-item';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Menu items';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Menu\Item';

    /**
     * Container condition
     * @var array|string
     */
    protected $_containerConditions = null;

    /**
     * Default grid params
     * @var array
     */
    protected $_defaultParams = [
        'sort' => 'id',
        'direction' => 'ASC',
        'page' => 1,
        'limit' => 10
    ];

    /**
     * Initialize grid columns
     *
     * @return void
     */
    protected function _initColumns()
    {
		$this->_columns = [
			'id'         => new Column\Primary('Id'),
            'menu'       => new Column\JoinOne('Menu', '\Core\Model\Menu\Menus'),
            'image'      => new Column\Image("Icon"),
            'title'      => new Column\Name('Title'),
			'module'     => new Column\JoinOne('Module', ['\Core\Model\Mvc\Controller', '\Core\Model\Mvc\Module']),
			'controller' => new Column\JoinOne('Controller', '\Core\Model\Mvc\Controller'),
            'parent'     => new Column\JoinOne('Parent', '\Core\Model\Menu\Item'),
            'parent_id'   => new Column\Numeric('Parent'),
            //'childs'    => new Column\JoinMany('Childs', '\Core\Model\Menu\Item', null, null, ', ', 5),
            'alias'      => new Column\Text('Alias'),
            'position'   => new Column\Numeric('Position'),
			'status'     => new Column\Collection("Status", 'status', ['active' => 'Active', 'not_active' => 'Not active']),
            'description'=> new Column\Text('Desc', 'description')
		];
		//$this->_columns['parent']->setAction('menu-item', 'parent');
    }

    /**
     * Initialize grid filters
     *
     * @return void
     */
    protected function _initFilters()
    {
        $this->_filter = new Filter([
			'search'    => new Field\Search('Search', 'search', [
				[
    				'path' => null,
    				'filters' => [
						Criteria::COLUMN_ID => Criteria::CRITERIA_EQ,
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
					]
				],
				[
					'path' => ['\Core\Model\Menu\Menus'],
					'filters' => [
						Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
					]
                ],
                [
                    'path' => ['\Core\Model\Menu\Item'],
                    'filters' => [
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ]
                ]
		    ]),
			'id'         => new Field\Primary('Id'),
            'controller' => new Field\Join('Controller', '\Core\Model\Mvc\Controller'),
       		'menu'       => new Field\Join('Menu', '\Core\Model\Menu\Menus'),
			'parent'     => new Field\Join('Parent', '\Core\Model\Menu\Item'),
            'status'     => new Field\ArrayToSelect('Status', 'status', ['active' => 'Active', 'not_active' => 'Not active'])
        ]);
    }
}
