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
 * Class Role
 *
 * @category    Module
 * @package     Acl
 * @subpackage  Grid
 */
class Role extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'acl-role';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Roles';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Acl\Role';

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
			'name'      => new Column\Name('Name'),
            //'accesslist'=> new Column\JoinMany('Role access list', '\Core\Model\Acl\Accesslist', null, null, ', ', 5),
			//'inherit'   => new Column\JoinMany('Role inherit', '\Core\Model\Acl\RoleInherit', null, null, ', ', 5),
            'description'      => new Column\Text('Desc', 'description')
		];
		//$this->_columns['inherit']->setAction('acl-role-inherit', 'role');
        //$this->_columns['accesslist']->setAction('acl-access-list', 'role');
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
                Criteria::COLUMN_ID     => Criteria::CRITERIA_EQ,
                Criteria::COLUMN_NAME   => Criteria::CRITERIA_BEGINS
			]),
			'id'        => new Field\Primary('Id'),
            'name'      => new Field\Name('Name')
        ]);
    }
}
