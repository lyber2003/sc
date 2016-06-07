<?php
/**
 * @namespace
 */
namespace Core\Model\Menu;

/**
 * Class Menus
 *
 * @category   Module
 * @package    Menu
 * @subpackage Model
 */
class Menus extends \Vein\Core\Mvc\Model
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany("id", "\Core\Model\Menu\Item", "menu_id", ['alias' => 'Item']);
    }

    /**
     * Return table name
     * @return string
     */
    public function getSource()
    {
        return "core_menu_menus";
    }
     
}
