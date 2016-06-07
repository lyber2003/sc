<?php
/**
 * @namespace
 */
namespace User\Form;

use Vein\Core\Crud\Form,
    Vein\Core\Crud\Form\Field;

/**
 * Class Access
 *
 * @category    Module
 * @package     User
 * @subpackage  Form
 */
class Login extends Form
{
    /**
     * Extjs form key
     * @var string
     */
    protected $_key = 'user-login';

    /**
     * Form title
     * @var string
     */
    protected $_title = 'Login';

    /**
     * Container model
     * @var string
     */
    protected $_containerModel = '\User\Model\User';

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
			'login' => new Field\Name('Имя', 'email'),
			'password' => new Field\Password('Пароль')
		];
    }
}
