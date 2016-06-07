<?php
/**
 * @namespace
 */
namespace Core\Form\Mvc;

use Vein\Core\Crud\Form,
    Vein\Core\Crud\Form\Field;

/**
 * Class
 *
 * @category    Module
 * @package     Mvc
 * @subpackage  Form
 */
class Action extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'mvc-action';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Action';

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
     * Initialize form fields
     *
     * @return void
     */
    protected function _initFields()
    {
		$this->_fields = [
			'id'        => new Field\Primary('Id'),
			'module'    => new Field\ManyToOne('Module', '\Core\Model\Mvc\Module', null),
			'controller'=> new Field\ManyToOne('Controller', '\Core\Model\Mvc\Controller'),
			'name'      => new Field\Name("Action"),
			'status'    => new Field\ArrayToSelect("Status", null, ['active' => 'Active', 'not_active' => 'Not active'])
		];
    }
}
