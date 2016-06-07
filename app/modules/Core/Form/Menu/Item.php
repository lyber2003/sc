<?php
/**
 * @namespace
 */
namespace Core\Form\Menu;

use Vein\Core\Crud\Form,
    Vein\Core\Crud\Form\Field;

/**
 * Class Item
 *
 * @category    Module
 * @package     Menu
 * @subpackage  Form
 */
class Item extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'menu-item';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Menu item';

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
     * Initialize form fields
     *
     * @return void
     */
    protected function _initFields()
    {
		$this->_fields = [
			'id'         => new Field\Primary('Id'),
			'menu'       => new Field\ManyToOne('Menu', '\Core\Model\Menu\Menus'),
			'title'      => new Field\Name('title'),
			'image'      => new Field\Image("Icon", 'image', 'upload', 'menu_item_{id}'),
            'parent'     => new Field\ManyToOne('Parent', '\Core\Model\Menu\Item'),
			//'childs'    => new Field\ManyToMany('Childs', '\Core\Model\Menu\Item', null, null, ', ', 5),
            'module'     => new Field\ManyToOne('Module', '\Core\Model\Mvc\Module', 'module'),
			'controller' => new Field\ManyToOne('Controller', '\Core\Model\Mvc\Controller'),
            'alias'      => new Field\Text('Alias'),
            'position'   => new Field\Text("Position"),
            'status'     => new Field\ArrayToSelect("Status", 'status', ['active' => 'Active', 'not_active' => 'Not active']),
            'description'=> new Field\HtmlEditor('Desciption', 'description')
		];
    }
}
