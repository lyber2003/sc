<?php
/**
 * @namespace
 */
namespace Core\Model\Acl;

/**
 * Class Accesslist
 *
 * @category   Module
 * @package    Acl
 * @subpackage Model
 */
class Accesslist extends \Vein\Core\Mvc\Model
{

    /**
     * Default order name
     * @var string
     */
    protected $_orderExpr = 'role_id';

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
    public $resource_id;
     
    /**
     *
     * @var string
     */
    public $access_id;
     
    /**
     *
     * @var integer
     */
    public $allowed;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo("role_id", "\Core\Model\Acl\Role", "id", ['alias' => 'Role']);
        $this->belongsTo("resource_id", "\Core\Model\Acl\Resource", "id", ['alias' => 'Resource']);
        $this->belongsTo("access_id", "\Core\Model\Acl\Access", "id", ['alias' => 'Access']);
    }

    /**
     * Return table name
     * @return string
     */
    public function getSource()
    {
        return "core_acl_access_list";
    }
     
}
