<?php
/**
 * @namespace
 */
namespace Frontend;

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
    protected $_moduleName = 'frontend';

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
        'dispatcher',
        'crypt',
        'acl',
        'auth',

        '\Frontend\Service\View',
        'viewer',

        '\User\Service\Module',
        '\Frontend\Service\Module'
    ];
}