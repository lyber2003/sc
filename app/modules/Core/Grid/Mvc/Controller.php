<?php
/**
 * @namespace
 */
namespace Core\Grid\Mvc;

use Vein\Core\Crud\Grid,
    Vein\Core\Crud\Grid\Column,
    Vein\Core\Crud\Grid\Filter\Extjs as Filter,
    Vein\Core\Crud\Grid\Filter\Field,
    Vein\Core\Filter\SearchFilterInterface as Criteria;

/**
 * Class
 *
 * @category    Module
 * @package     Mvc
 * @subpackage  Grid
 */
class Controller extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'mvc-controller';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Controllers';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Mvc\Controller';

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
			'id'     => new Column\Primary('Id'),
			'module' => new Column\JoinOne('Module', '\Core\Model\Mvc\Module'),
			'name'   => new Column\Name("Controller"),
			//'action' => new Column\JoinMany('Actions', '\Core\Model\Mvc\Action', null, null, ', ', 5),
			'status' => new Column\Collection("Status", null, ['active' => 'Active', 'not_active' => 'Not active'])
		];

		//$this->_columns['actions']->setAction ('mvc-action', 'controller');
    }

    /**
     * Initialize grid filters
     *
     * @return void
     */
    protected function _initFilters()
    {
        $this->_filter = new Filter([
			'search' => new Field\Search('Search', 'search', [
                [
                    'path' => null,
                    'filters' => [
                        Criteria::COLUMN_ID => Criteria::CRITERIA_EQ,
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ],
                ],
                [
                    'path' => ['\Core\Model\Mvc\Module'],
                    'filters' => [
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ]
                ]
    		]),
			'id'     => new Field\Primary('Id'),
       		'module' => new Field\Join('Modules', '\Core\Model\Mvc\Module'),
            'status' => new Field\ArrayToSelect('Status', 'status', ['active' => 'Active', 'not_active' => 'Not active'])
        ]);
    }
}
