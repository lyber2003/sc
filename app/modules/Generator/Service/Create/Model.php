<?php
/**
 * @namespace
 */
namespace Generator\Service\Create;

use Phalcon\DI\InjectionAwareInterface,
    Vein\Core\Tools\Traits\DIaware,

    Vein\Core\Builder\Model as ModelBuilder,
    Vein\Core\Builder\Script\Color;

/**
 * Class Model
 *
 * @category   Service
 * @package    Generator
 */
class Model implements InjectionAwareInterface
{
    use DIaware;

    /**
     * Generate new model
     *
     * @param string $tableName
     *
     * @return void
     */
    public function create($tableName)
    {
        $config = $this->getDi()->get('config');

        print Color::head("Start creating model for table '".$tableName."'") . PHP_EOL;
        $ModelBuilder = new ModelBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $ModelBuilder->build();
    }

} 