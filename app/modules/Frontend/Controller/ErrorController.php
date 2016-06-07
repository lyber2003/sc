<?php
/**
 * @namespace
 */
namespace Frontend\Controller;

/**
 * Class ErrorController
 *
 * @category  Controller
 * @package   Frontend
 */
class ErrorController extends \Phalcon\Mvc\Controller
{

    /**
     * Execute action for 'get' rest frontend http method
     */
    public function show404Action($id = null)
    {
        // Set status code
        $this->response->setStatusCode(404, "Not Found");

        return true;
    }

    /**
     * Execute action for 'get' rest frontend http method
     */
    public function show503Action($id = null)
    {
        // Set status code
        $this->response->setStatusCode(503, "Server error");
        
        return true;
    }

}

