<?php
/**
 * @namespace
 */
namespace Core\Form\Acl;

use Vein\Core\Crud\Form,
    Vein\Core\Crud\Form\Field;

/**
 * Class Accesslist
 *
 * @category    Module
 * @package     Acl
 * @subpackage  Form
 */
class Accesslist extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'acl-accesslist';

    /**
     * Form title
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
     * Initialize form fields
     *
     * @return void
     */
    protected function _initFields()
    {
		$this->_fields = [
			'id'        => new Field\Primary('Id'),
            'role'      => new Field\ManyToOne('Role', '\Core\Model\Acl\Role'),
			'resource'  => new Field\ManyToOne('Resource', '\Core\Model\Acl\Resource'),
			'access'    => new Field\ManyToOne('Access', '\Core\Model\Acl\Access'),
            'allowed'   => new Field\ArrayToSelect('Status', null, ['0' => 'not active', '1' => 'active'])
		];
    }
}
