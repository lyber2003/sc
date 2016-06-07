<?php
/**
 * @namespace
 */
namespace Admin\Service;

use Phalcon\DI\InjectionAwareInterface,
    Vein\Core\Tools\Traits\DIaware;

/**
 * Class ViewHelper
 *
 * @category   Service
 * @package    Admin
 */
class ViewHelper implements InjectionAwareInterface
{
    use DIaware;

    /**
     * View service
     * @var \Phalcon\Mvc\ViewInterface
     */
    protected $_view;

    /**
     * ViewHelper constructor.
     *
     * @param \Phalcon\Mvc\ViewInterface $view
     */
    public function __construct(\Phalcon\Mvc\ViewInterface $view)
    {
        $this->_view = $view;
    }

    /**
     * Render header template
     *
     * @param array $params
     *
     * @return string
     */
    public function header(array $params = [])
    {
        return $this->_view->partial('partial/header', $params);
    }

    /**
     * Render footer template
     *
     * @param array $params
     *
     * @return string
     */
    public function footer(array $params = [])
    {
        return $this->_view->partial('partial/footer', $params);
    }
} 