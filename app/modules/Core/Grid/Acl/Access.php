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
 * Class Privilege
 *
 * @category    Module
 * @package     Acl
 * @subpackage  Grid
 */
class Access extends Grid
{
    /**
     * Extjs grid key
     * @var string
     */
    protected $_key = 'acl-access';

    /**
     * Grid title
     * @var string
     */
    protected $_title = 'Accesses';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Acl\Access';

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
			'id'         => new Column\Primary('Id'),
			'name'       => new Column\Name('Name'),
			'resource'   => new Column\JoinOne('Resource', '\Core\Model\Acl\Resource'),
            //'accesslist' => new Column\JoinMany('Access list', '\Core\Model\Acl\Accesslist', null, null, ', ', 5),
		];
        //$this->_columns['accesslist']->setAction('acl-access-list', 'access');
        $this->addAdditional('grid', 'Core', 'AclAccesslist', 'access');
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
                ]
			]),
			'id'       => new Field\Primary('Id'),
            'name'     => new Field\Name('Name'),
            'resource' => new Field\Join('Resource', '\Core\Model\Acl\Resource')
        ]);
    }
}
