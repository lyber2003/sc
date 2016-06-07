<?php
/**
 * @namespace
 */
namespace User\Model;

use Vein\Core\Mvc\Model;

/**
 * Class Role
 *
 * @category    Model
 * @package     User
 */
class Role extends \Vein\Core\Mvc\Model
{
    /**
     * Default name column
     * @var string
     */
    protected $_nameExpr = 'name';

    /**
     * Default order name
     * @var string
     */
    protected $_orderExpr = 'name';

    /**
     * Order is asc order direction
     * @var bool
     */
    protected $_orderAsc = true;

    /**
     *
     * @var integer
     */
    public $id;
     
    /**
     *
     * @var string
     */
    public $name;
     
    /**
     *
     * @var string
     */
    public $description;

    /**
     * Initialize method for model.
     *
     * @return void
     */
    public function initialize()
    {
    }

    /**
     * Return table name
     * @return string
     */
    public function getSource()
    {
        return 'core_acl_role';
    }
     
}
