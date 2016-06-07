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
class Action extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'mvc-action';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Actions';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Mvc\Action';

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
			'id'        => new Column\Primary('Id'),
			'module'   => new Column\JoinOne('Module', ['\Core\Model\Mvc\Controller', '\Core\Model\Mvc\Module']),
			'controller'=> new Column\JoinOne('Controller', '\Core\Model\Mvc\Controller'),
			'name'      => new Column\Name("Action"),
			'status'    => new Column\Collection("Status", 'status', ['active' => 'Active', 'not_active' => 'Not active'])
		];
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
					],
				],
				[
					'path' => ['\Core\Model\Mvc\Controller'],
					'filters' => [
						Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
					]
				],
				[
					'path' => ['\Core\Model\Mvc\Controller', '\Core\Model\Mvc\Module'],
					'filters' => [
						Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
					]
				]
			]),
    		'id'         => new Field\Primary('Id'),
    		'module'     => new Field\Join('Modules', '\Core\Model\Mvc\Module', ['\Core\Model\Mvc\Controller', '\Core\Model\Mvc\Module']),
       		'controller' => new Field\Join('Controllers', '\Core\Model\Mvc\Controller'),
            'status'     => new Field\ArrayToSelect('Status', 'status', ['active' => 'Active', 'not_active' => 'Not active'])
        ]);
    }
}
