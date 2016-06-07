<?php
/**
 * @namespace
 */
namespace User\Model;

use Vein\Core\Mvc\Model,
    Vein\Core\Acl\AuthModelInterface,
    Vein\Core\Acl\Tools\User as UserAcl,
    \Phalcon\Mvc\Model\Validator\Uniqueness;

/**
 * Class User
 *
 * @category    Model
 * @package     User
 */
class User extends Model implements AuthModelInterface
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
    public $login;

    /**
     *
     * @var integer
     */
    public $phone_id;

    /**
     *
     * @var string
     */
    public $auth_key;

    /**
     *
     * @var string
     */
    public $password_hash;

    /**
     *
     * @var string
     */
    public $password_reset_token;

    /**
     *
     * @var integer
     */
    public $address_id;

    /**
     *
     * @var integer
     */
    public $personal_id;

    /**
     *
     * @var integer
     */
    public $social_id;

    /**
     *
     * @var integer
     */
    public $person_owner_id;

    /**
     *
     * @var integer
     */
    public $employment_id;

    /**
     *
     * @var integer
     */
    public $financial_id;

    /**
     *
     * @var integer
     */
    public $state_id;

    /**
     *
     * @var integer
     */
    public $obj_init_id;

    /**
     *
     * @var string
     */
    public $pasportscan_verified;

    /**
     *
     * @var string
     */
    public $maxamount;

    /**
     *
     * @var string
     */
    public $is_fraud;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('id', 'Card', 'client_id', array('alias' => 'Card'));
        $this->belongsTo('obj_init_id', 'Obj', 'obj_id', array('alias' => 'Obj'));
        $this->belongsTo('state_id', 'Ref', 'obj_id', array('alias' => 'Ref'));
        $this->belongsTo('person_owner_id', 'PersonNs', 'obj_id', array('alias' => 'PersonNs'));
        $this->belongsTo('address_id', 'Address', 'id', array('alias' => 'Address'));
        $this->belongsTo('phone_id', 'Phone', 'id', array('alias' => 'Phone'));
        $this->belongsTo('employment_id', 'Employment', 'id', array('alias' => 'Employment'));
        $this->belongsTo('financial_id', 'Financial', 'id', array('alias' => 'Financial'));
        $this->belongsTo('personal_id', 'Personal', 'id', array('alias' => 'Personal'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'client';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Person2client[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Person2client
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function setName($name)
    {
        // Имя слишком короткое?
        if (strlen($name) < 10) {
            throw new \InvalidArgumentException('Имя слишком короткое');
        }
        $this->name = $name;
    }

}
