<?php
/**
 * @namespace
 */
namespace User\Grid;

use Vein\Core\Crud\Grid as Grid,
    Vein\Core\Crud\Grid\Column,
    Vein\Core\Crud\Grid\Filter as Filter,
    Vein\Core\Crud\Grid\Filter\Field,
    Vein\Core\Filter\SearchFilterInterface as Criteria;;

/**
 * Class User
 *
 * @category    Grid
 * @package     Ap
 */
class User extends Grid
{
    protected $_title = 'User';

    protected $_containerModel = 'User\Model\User';

    /**
	 * Initialize grid columns
	 *
	 * @return void
	 */
	protected function _initColumns()
    {
		$this->_columns = [
			'id' => new Column\Primary('Id'),
            'email' => new Column\Text('Email', 'email'),
			'username' => new Column\Text('Username', 'username'),
			//'gender' => new Column\Collection('Gender', 'gender', ['0' => 'female', '1' => 'male']),
			'firstname' => new Column\Text('Firstname', 'firstname'),
			'lastname' => new Column\Text('Lastname', 'lastname'),
			'avatar_url' => new Column\Text('Avatar Url', 'avatar_url'),
			'birthday' => new Column\Text('Birthday', 'birthday'),
			'state' => new Column\Text('State', 'state'),
			//'country' => new Column\JoinOne('Country', 'User\Model\Country'),
            //'user_role' => new Column\JoinOne('User Role', 'User\Model\Role'),
			/*
			'get_correspondence' => new Column\Collection('Get Correspondence', 'get_correspondence', ['0' => 'no', '1' => 'yes']),
			'slogan' => new Column\Text('Slogan', 'slogan'),
			'firstname_is_public' => new Column\Collection('Firstname Is Public', 'firstname_is_public', ['0' => 'no', '1' => 'yes']),
			'lastname_is_public' => new Column\Collection('Lastname Is Public', 'lastname_is_public', ['0' => 'no', '1' => 'yes']),
			'email_is_public' => new Column\Collection('Email Is Public', 'email_is_public', ['0' => 'no', '1' => 'yes']),
			'birthyear_is_public' => new Column\Collection('Birthyear Is Public', 'birthyear_is_public', ['0' => 'no', '1' => 'yes']),
			'birthother_is_public' => new Column\Collection('Birthother Is Public', 'birthother_is_public', ['0' => 'no', '1' => 'yes']),
			'state_is_public' => new Column\Collection('State Is Public', 'state_is_public', ['0' => 'no', '1' => 'yes']),
			'interest_area_is_public' => new Column\Collection('Interest Area Is Public', 'interest_area_is_public', ['0' => 'no', '1' => 'yes']),
			'avatar_is_public' => new Column\Collection('Avatar Is Public', 'avatar_is_public', ['0' => 'no', '1' => 'yes']),
			'created_at' => new Column\Text('Created At', 'created_at'),
			'updated_at' => new Column\Text('Updated At', 'updated_at'),
			'activekey' => new Column\Text('Activekey', 'activekey'),
			'points' => new Column\Numeric('Points', 'points'),
			'logged_in_at' => new Column\Text('Logged In At', 'logged_in_at'),
			'prev_logged_in_at' => new Column\Text('Prev Logged In At', 'prev_logged_in_at'),
            */
		 ];
    }

    /**
	 * Initialize grid filters
	 *
	 * @return void
	*/
    protected function _initFilters()
    {
        $this->_filter = new Filter([
            'id' => new Field\Primary('Id'),
            'username' => new Field\Standart('Username', 'username', null, Criteria::CRITERIA_EQ),
            'email' => new Field\Standart('Email', 'email', null, Criteria::CRITERIA_EQ),
            //'user_role' => new Field\Join('User Role', 'User\Model\Role'),
            //'gender' => new Field\ArrayToSelect('Gender', 'gender', ['0' => 'female', '1' => 'male'])

        ], null, 'get');
    }

}
