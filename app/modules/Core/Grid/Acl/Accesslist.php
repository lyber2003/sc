<?php
/**
 * @namespace
 */
namespace Core\Grid\Acl;

use Vein\Core\Crud\Grid,
    Vein\Core\Crud\Grid\Column,
    Vein\Core\Crud\Grid\Filter\Extjs as Filter,
    Vein\Core\Crud\Grid\Filter\Field,
    Vein\Core\Filter\SearchFilterInterface as Criteria;

/**
 * Class Accesslist
 *
 * @category    Module
 * @package     Acl
 * @subpackage  Grid
 */
class Accesslist extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'acl-accesslist';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Access list';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Acl\Accesslist';

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
			'id'       => new Column\Primary('Id'),
            'role'     => new Column\JoinOne('Role', '\Core\Model\Acl\Role'),
			'resource' => new Column\JoinOne('Resource', '\Core\Model\Acl\Resource'),
			'access'   => new Column\JoinOne('Access', '\Core\Model\Acl\Access'),
            'allowed'  => new Column\Collection('Status', null, ['0' => 'not active', '1' => 'active'])
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
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS,
                    ],
                ],
                [
                    'path' => 'Core\Model\Acl\Resource',
                    'filters' => [
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ],
                ],
                [
                    'path' => 'Core\Model\Acl\Access',
                    'filters' => [
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ],
                ],
                [
                    'path' => 'Core\Model\Acl\Role',
                    'filters' => [
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ],
                ]
			]),
			'id'       => new Field\Primary('Id'),
            'role'     => new Field\Join('Role', '\Core\Model\Acl\Role'),
            'resource' => new Field\Join('Resource', '\Core\Model\Acl\Resource'),
			'access'   => new Field\Join('Access', '\Core\Model\Acl\Access')
        ]);
    }
}
