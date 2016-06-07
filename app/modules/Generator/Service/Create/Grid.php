<?php
/**
 * @namespace
 */
namespace Generator\Service\Create;

use Phalcon\DI\InjectionAwareInterface,
    Vein\Core\Tools\Traits\DIaware,

    Vein\Core\Builder\Grid as GridBuilder,
    Vein\Core\Builder\Script\Color;

/**
 * Class Grid
 *
 * @category   Service
 * @package    Generator
 */
class Grid implements InjectionAwareInterface
{
    use DIaware;

    /**
     * Generate new Grid
     *
     * @param string $tableName
     *
     * @return void
     */
    public function create($tableName)
    {
        $config = $this->getDi()->get('config');

        print Color::head("Start creating grid for table '".$tableName."'") . PHP_EOL;
        $GridBuilder = new GridBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $GridBuilder->build();
    }

} 