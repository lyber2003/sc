<?php
/**
 * @namespace
 */
namespace Core\Form\Acl;

use Vein\Core\Crud\Form,
    Vein\Core\Crud\Form\Field;

/**
 * Class Role
 *
 * @category    Module
 * @package     Acl
 * @subpackage  Form
 */
class Role extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'acl-role';

    /**
     * Form title
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
     * Initialize form fields
     *
     * @return void
     */
    protected function _initFields()
    {
		$this->_fields = [
			'id'         => new Field\Primary('Id'),
			'name'       => new Field\Name('Name'),
            'description'=> new Field\Text('Desc', 'description')
		];
    }
}
