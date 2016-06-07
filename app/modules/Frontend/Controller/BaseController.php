<?php
/**
 * @namespace
 */
namespace Frontend\Controller;

use User\Model\User as UserModel;

/**
 * Class SearchController
 *
 * @category  Controller
 * @package   Frontend
 */
class BaseController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        $this->setViewGlobalVars();
    }

    /**
     * Set global vars for all views
     */
    public function setViewGlobalVars()
    {
        $userId = $this->session->get("userId");
        if ($userId > 0){
            $this->view->setVar( 'authorised', true);
        } else {
            $this->view->setVar( 'authorised', false);
        }
        $this->view->setVar('url', "$_SERVER[APP_HOME_URL]$_SERVER[REQUEST_URI]");
        $this->view->setVar('ENV', env('APP_ENV'));
        $this->view->setVar('scriptsVersion', $this->config->application->view->scriptsVersion);
        $this->view->setVar('siteName', 'SosCredit');
    }
}