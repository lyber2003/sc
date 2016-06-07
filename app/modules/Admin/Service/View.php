<?php
/**
 * @namespace
 */
namespace Admin\Service;

use Vein\Core\Mvc\Module\Service\AbstractService,
    Vein\Core\Mvc\View\Engine\Jade;

/**
 * Class View
 *
 * @category   Service
 * @package    Admin
 */
class View extends AbstractService
{
    /**
     * Initializes Jade engine
     */
    public function register()
    {
        $dependencyInjector = $this->getDi();
        $eventsManager = $this->getEventsManager();

        $config = $this->_config;
        $moduleDirectory = $this->_module->getModuleDirectory();
        $defaultModuleDir = $this->_module->getDefaultModuleDirectory();

        $dependencyInjector->set('view', function () use ($dependencyInjector, $moduleDirectory, $defaultModuleDir, $eventsManager, $config) {

            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir($moduleDirectory.'/Jade/');

            $view->registerEngines([
                '.jade' => function($view, $di) use ($config) {
                    return new Jade($view, $di, [
                        'cache' => !$config->application->view->cacheModeNone ? CACHE_PATH . '/jade' : false,
                        'prettyprint' => $config->application->view->prettyprint,
                        'extension' => '.jade',
                    ]);
                }
            ]);

            // Attach a listener for type "view"
            if (!$config->application->debug) {
                $eventsManager->attach('view', function ($event, $view) use ($dependencyInjector) {
                    if ($event->getType() == 'notFoundView') {
                        $dependencyInjector->get('logger')->error('View not found - "'.$view->getActiveRenderPath().'"');
                    }
                });

                $view->setEventsManager($eventsManager);
            } elseif ($config->application->profiler) {
                $eventsManager->attach('view', function ($event, $view) use ($dependencyInjector) {
                    if ($dependencyInjector->has('profiler')) {
                        if ($event->getType() == 'beforeRender') {
                            $dependencyInjector->get('profiler')->start();
                        }
                        if ($event->getType() == 'afterRender') {
                            $dependencyInjector->get('profiler')->stop($view->getActiveRenderPath(), 'view');
                        }
                    }
                    if ($event->getType() == 'notFoundView') {
                        $dependencyInjector->get('logger')->error('View not found - "'.$view->getActiveRenderPath().'"');
                    }
                });
                $view->setEventsManager($eventsManager);
            }

            return $view;
        });
    }
} 