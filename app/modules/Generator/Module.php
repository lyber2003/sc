<?php
/**
 * @namespace
 */
namespace Generator;

use Vein\Core\Mvc\Module as BaseModule;

/**
 * Class Event Module
 *
 * @category   Module
 * @package    Event
 */
class Module extends BaseModule
{
	/**
	 * Module name
	 * @var string
	 */
	protected $_moduleName = 'generator';

	/**
	 * Autoload module prefixes
	 * @var array
	 */
	protected $_loaders = [
			'controller',
			'model',
			'grid'
	];

	/**
	 * Register module services
	 * @var array
	 */
	protected $_services = [
			'registry',
			'crypt',

			'\Generator\Service\Module'
	];
}