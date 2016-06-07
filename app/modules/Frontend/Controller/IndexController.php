<?php
/**
 * @namespace
 */
namespace Frontend\Controller;

/**
 * Class IndexController
 *
 * @category  Controller
 * @package   Frontend
 */
class IndexController extends BaseController
{
    /**
     * Execute action for 'post' rest frontend http method
     *
     * @return mixed
     * @Access(allowed)
     */
    public function indexAction($id = null)
    {
        /**
         * @var $viewHelper \Frontend\Service\ViewHelper
         */
        $this->view->setMainView('pages/frontend/index');
        //$viewHelper = $this->getDi()->get('viewHelper');
        //$viewHelper->header();

    }
}