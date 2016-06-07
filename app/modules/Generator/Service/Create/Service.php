<?php
/**
 * @namespace
 */
namespace Generator\Service\Create;

use Phalcon\DI\InjectionAwareInterface,
    Vein\Core\Tools\Traits\DIaware,

    Vein\Core\Builder\Service as ServiceBuilder,
    Vein\Core\Builder\Script\Color;

/**
 * Class Service
 *
 * @category   Service
 * @package    Generator
 */
class Service implements InjectionAwareInterface
{
    use DIaware;

    /**
     * Generate new Service
     *
     * @param string $tableName
     *
     * @return void
     */
    public function create($tableName)
    {
        $config = $this->getDi()->get('config');

        print Color::head("Start creating service '".$tableName."'") . PHP_EOL;
        $ServiceBuilder = new ServiceBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $ServiceBuilder->build();
    }

} 