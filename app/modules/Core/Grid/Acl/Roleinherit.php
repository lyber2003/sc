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
 * Class Roleinherit
 *
 * @category    Module
 * @package     Acl
 * @subpackage  Grid
 */
class Roleinherit extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'acl-roleinherit';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Role inherits';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Acl\Roleinherit';

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
			'id'      => new Column\Primary('Id'),
			'role'    => new Column\JoinOne('Role', '\Core\Model\Acl\Role'),
            'inherit' => new Column\JoinOne('Inherit role', '\Core\Model\Acl\RoleToInherit')
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
			'search' => new Field\Search('Search', 'search', [
                [
                    'path' => null,
                    'filters' => [
                        Criteria::COLUMN_ID => Criteria::CRITERIA_EQ,
                    ],
                ],
                [
                    'path' => 'Core\Model\Acl\Role',
                    'filters' => [
                        Criteria::COLUMN_NAME => Criteria::CRITERIA_BEGINS
                    ],
                ]
			]),
			'id'   => new Field\Primary('Id'),
			'role' => new Field\Join('Roles', '\Core\Model\Acl\Role')
        ]);
    }
}
