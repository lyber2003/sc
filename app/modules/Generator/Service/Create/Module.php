<?php
/**
 * @namespace
 */
namespace Generator\Service\Create;

use Phalcon\DI\InjectionAwareInterface,
    Vein\Core\Tools\Traits\DIaware,

    Vein\Core\Builder\Model as ModelBuilder,
    Vein\Core\Builder\Grid as GridBuilder,
    Vein\Core\Builder\Form as FormBuilder,
    Vein\Core\Builder\Service as ServiceBuilder,

    Vein\Core\Builder\Script\Color;

/**
 * Class Model
 *
 * @category   Service
 * @package    Generator
 */
class Module implements InjectionAwareInterface
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
        $builder = new ModelBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $builder->build();

        print Color::head("Start creating grid for table '".$tableName."'") . PHP_EOL;
        $builder = new GridBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $builder->build();

        print Color::head("Start creating form for table '".$tableName."'") . PHP_EOL;
        $builder = new FormBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $builder->build();

        print Color::head("Start creating service '".$tableName."'") . PHP_EOL;
        $ServiceBuilder = new ServiceBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $ServiceBuilder->build();

    }
} 