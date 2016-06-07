<?php
/**
 * @namespace
 */
namespace Core\Model\Acl;

/**
 * Class Roleinherit
 *
 * @category   Module
 * @package    Acl
 * @subpackage Model
 */
class Roleinherit extends \Vein\Core\Mvc\Model
{
    /**
     * Default name column
     * @var string
     */
    protected $_nameExpr = 'role_id';

    /**
     * Default order name
     * @var string
     */
    protected $_orderExpr = 'role_id';

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
    public $role_id;
     
    /**
     *
     * @var string
     */
    public $inherit_role_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo("role_id", "\Core\Model\Acl\Role", "id", ['alias' => 'Role']);
        $this->belongsTo("inherit_role_id", "\Core\Model\Acl\RoleToInherit", "id", ['alias' => 'RoleToInherit']);
    }

    /**
     * Return table name
     * @return string
     */
    public function getSource()
    {
        return "core_acl_role_inherit";
    }
     
}
