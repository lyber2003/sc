<?php
/**
 * @namespace
 */
namespace Admin;

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
    protected $_moduleName = 'admin';

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
        '\Admin\Service\View',
        'dispatcher',
        'crypt',
        'acl',
        'auth',

        'viewer',

        '\User\Service\Module',
        '\Admin\Service\Module',
        '\Core\Service\Module'
    ];

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }
}