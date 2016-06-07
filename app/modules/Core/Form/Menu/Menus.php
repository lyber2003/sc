<?php
/**
 * @namespace
 */
namespace Core\Form\Menu;

use Vein\Core\Crud\Form,
    Vein\Core\Crud\Form\Field;

/**
 * Class
 *
 * @category    Module
 * @package     Menu
 * @subpackage  Form
 */
class Menus extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'menu-menus';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Menus';

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
     * Initialize form fields
     *
     * @return void
     */
    protected function _initFields()
    {
		$this->_fields = [
			'id'    => new Field\Primary('Id'),
			'name'   => new Field\Name('Name'),
			//'item'  => new Field\ManyToMany('Items', '\Core\Model\Menu\Item', null, null, ', ', 5, '150')
		];
    }
}
