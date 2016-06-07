<?php
/**
 * @namespace
 */
namespace Core\Model\Acl;

/**
 * Class Access
 *
 * @category   Module
 * @package    Acl
 * @subpackage Model
 */
class Access extends \Vein\Core\Mvc\Model
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
    protected $_orderExpr = 'resource_id';

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
    public $resource_id;
     
    /**
     *
     * @var string
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo("resource_id", "\Core\Model\Acl\Resource", "id", ['alias' => 'Resource']);
        $this->hasMany("id", "\Core\Model\Acl\Accesslist", "access_id", ['alias' => 'Accesslist']);
    }

    /**
     * Return table name
     * @return string
     */
    public function getSource()
    {
        return "core_acl_resource_access";
    }
     
}
