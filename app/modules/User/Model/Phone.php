<?php
/**
 * @namespace
 */
namespace User\Model;

use Vein\Core\Mvc\Model,
    Vein\Core\Acl\AuthModelInterface,
    Vein\Core\Acl\Tools\User as UserAcl;


/**
 * Class User
 *
 * @category    Model
 * @package     User
 */
class Phone extends Model implements AuthModelInterface
{
    use UserAcl;
    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $telmain;

    /**
     *
     * @var string
     */
    public $telhome;

    /**
     *
     * @var string
     */
    public $telext;

    /**
     *
     * @var string
     */
    public $telwork;

    /**
     *
     * @var string
     */
    public $tellived;

    /**
     *
     * @var string
     */
    public $is_history;

    /**
     *
     * @var string
     */
    public $create_time;

    /**
     *
     * @var string
     */
    public $update_time;

    /**
     *
     * @var integer
     */
    public $init_obj_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('id', 'Person2client', 'phone_id', array('alias' => 'Person2client'));
        $this->belongsTo('init_obj_id', 'Obj', 'obj_id', array('alias' => 'Obj'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'phone';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Phone[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Phone
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
