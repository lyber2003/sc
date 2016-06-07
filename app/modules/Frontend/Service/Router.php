<?php
/**
 * @namespace
 */
namespace Frontend\Service;

use Vein\Core\Application\Service\AbstractService,
    Phalcon\Mvc\Router\Group as RouterGroup;

/**
 * Class Router
 *
 * @category   Service
 * @package    Frontend
 */
class Router extends AbstractService
{
    /**
     * Initializes router system
     *
     * @return void
     */
    public function init()
    {
        $dependencyInjector = $this->getDi();
        $router = $dependencyInjector->get('router');
        $config = $dependencyInjector->get('config');

        $frontendRouterGroup = new RouterGroup([
            'module'    =>  'frontend',
            'namespace' =>  '\Frontend\Controller',
            'controller'=> 'error',
            'action'    => '404'
        ]);

        //$frontendRouterGroup->setPrefix('/');

        $frontendRouterGroup->add('/:controller/:action/:params', [
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ]);

        $frontendRouterGroup->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2
        ]);

        $frontendRouterGroup->add('/:controller', [
            'controller' => 1,
            'action' => 'index'
        ]);

        $frontendRouterGroup->add('/', [
            'controller' => 'index',
            'action' => 'index'
        ]);


        $router->mount($frontendRouterGroup);
    }
} 