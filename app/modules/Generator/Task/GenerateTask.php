<?php
namespace Generator\Task;

use Generator\Service;

/**
 * Class GenerateTask
 *
 * @category   Service
 * @package    Generator
 */
class GenerateTask extends \Phalcon\CLI\Task
{

    /**
     * Generate new model
     *
     * @throws \Vein\Core\Exception
     */
    public function modelAction()
    {
        $params = $this->dispatcher->getParams();
        if (!isset($params[0])) {
            throw new \Vein\Core\Exception('Table name not set');
        }
        $model = $this->getDI()->get('generatorCreateModelService');
        $model->create($params[0]);
    }

    /**
     * Generate new grid
     *
     * @throws \Vein\Core\Exception
     */
    public function gridAction()
    {
        $params = $this->dispatcher->getParams();
        if (!isset($params[0])) {
            throw new \Vein\Core\Exception('Grid name not set');
        }
        $model = $this->getDI()->get('generatorCreateGridService');
        $model->create($params[0]);
    }

    /**
     * Generate new form
     *
     * @throws \Vein\Core\Exception
     */
    public function formAction()
    {
        $params = $this->dispatcher->getParams();
        if (!isset($params[0])) {
            throw new \Vein\Core\Exception('Form name not set');
        }
        $model = $this->getDI()->get('generatorCreateFormService');
        $model->create($params[0]);
    }

    /**
     * Generate new form
     *
     * @throws \Vein\Core\Exception
     */
    public function serviceAction()
    {
        $params = $this->dispatcher->getParams();
        if (!isset($params[0])) {
            throw new \Vein\Core\Exception('Service name not set');
        }
        $model = $this->getDI()->get('generatorCreateService');
        $model->create($params[0]);
    }

    /**
     * Generate new form
     *
     * @throws \Vein\Core\Exception
     */
    public function moduleAction()
    {
        $params = $this->dispatcher->getParams();
        if (!isset($params[0])) {
            throw new \Vein\Core\Exception('Module name not set');
        }
        $model = $this->getDI()->get('generatorCreateModuleService');
        $model->create($params[0]);
    }

    /**
     * Generate new form
     *
     * @throws \Vein\Core\Exception
     */
    public function testAction()
    {
        $params = $this->dispatcher->getParams();
        if (!isset($params[0])) {
            throw new \Vein\Core\Exception('Module name not set');
        };
        /**
         * @var $model \Generator\Service\Create\Test
         */
        $model = $this->getDI()->get('generatorCreateTestService');
        $model->create($params[0]);
    }
}