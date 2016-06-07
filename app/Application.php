<?php
use Vein\Core\Application as BaseApplication;

/**
 * Class Application
 *
 * @category   App
 * @package    API
 */
class Application extends BaseApplication
{

    /**
     * Config path
     * @var string
     */
    protected $_configPath = '/app/config';

    /**
     * Loaders for different modes.
     *
     * @var array
     */
    protected $_services = [
        'logger',
        'loader',
        'environment',
        'url',
        'cache',
        'annotations',
        'database',
        'session',
        'router',
        '\Frontend\Service\Router',
        '\Admin\Service\Router',
        //'flash'
    ];
}