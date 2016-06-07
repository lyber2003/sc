<?php
/**
 * @namespace
 */
namespace Generator\Service\Create;

use Phalcon\DI\InjectionAwareInterface,
    Vein\Core\Tools\Traits\DIaware,

    Vein\Core\Builder\Form as FormBuilder,
    Vein\Core\Builder\Script\Color;

/**
 * Class Form
 *
 * @category   Service
 * @package    Generator
 */
class Form implements InjectionAwareInterface
{
    use DIaware;

    /**
     * Generate new Form
     *
     * @param string $tableName
     *
     * @return void
     */
    public function create($tableName)
    {
        $config = $this->getDi()->get('config');

        print Color::head("Start creating form for table '".$tableName."'") . PHP_EOL;
        $FormBuilder = new FormBuilder([
            'table_name' => $tableName,
            'config_path' => APPLICATION_PATH.'/config',
            //'forceContinue' => true
        ]);
        $FormBuilder->build();
    }

} 