<?php
/**
 * @namespace
 */
namespace Admin\Service;

use Vein\Core\Application\Service\AbstractService,
    Phalcon\Mvc\Router\Group as RouterGroup;

/**
 * Class Router
 *
 * @category   Service
 * @package    Admin
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

        $adminRouterGroup = new RouterGroup([
            'module'    =>  'admin',
            'namespace' =>  '\Admin\Controller',
            'controller'=> 'admin',
            'action'    =>  'index'
        ]);

        $router->removeExtraSlashes(true);

        $adminRouterGroup->setPrefix('/admin');

        $adminRouterGroup->add('/:controller/:action/:moduleParam/:serviceParam', [
            'controller' => 1,
            'action' => 2,
            'moduleParam' => 3,
            'serviceParam' => 4
        ]);

        $adminRouterGroup->add('/:controller/:action/:params', [
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ]);

        $adminRouterGroup->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2
        ]);

        $adminRouterGroup->add('/:action', [
            'controller' => 'admin',
            'action' => '1'
        ]);

        $adminRouterGroup->add('', [
            'controller' => 'admin',
            'action' => 'index'
        ]);

        $router->mount($adminRouterGroup);
    }
} 