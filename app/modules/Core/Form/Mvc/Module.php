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
class Module extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'mvc-module';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Module';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\Core\Model\Mvc\Module';

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
			'name'      => new Field\Name("Module"),
			//'controller'=> new Field\ManyToMany('Controllers', '\Core\Model\Mvc\Controller', null, null, ', ', 5),
			'status'    => new Field\ArrayToSelect("Status", null, ['active' => 'Active', 'not_active' => 'Not active'])
		];
    }
}
