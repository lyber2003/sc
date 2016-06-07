<?php
use Vein\Core\Application\Cli as BaseApplication;

/**
 * Class Cli
 *
 * @category   App
 * @package    API
 */
class Cli extends BaseApplication
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
        'annotations',
        'database',
        //'session',
        //'flash'
    ];
}