<?php
/**
 * @namespace
 */
namespace Core\Service;

use Phalcon\DI\InjectionAwareInterface,
    Phalcon\Db\RawValue,
    Vein\Core\Tools\Traits\DIaware,

    Core\Model\Menu\Menus as MenuModel,
    Vein\Core\Tools\Arrays,

    Core\Traits\Grid\Menu as MenuGrid,
    Core\Traits\Grid\Item as ItemGrid,

    Vein\Core\Cache\Traits\Cacher;

/**
 * Class Menu
 *
 * @category   Service
 * @package    Menu
 */
class Menu implements InjectionAwareInterface
{
    use DIaware,
        Cacher,

        MenuGrid,
        ItemGrid;

    /**
     * Menu model
     *
     * @var MenuModel
     */
    private $_menuModel;

    /**
     * Constructor
     *
     * @param MenuModel $menuModel
     */
    public function __construct(
        MenuModel $menuModel
    ) {
        $this->_menuModel = $menuModel;
    }

    /**
     * Find and return Menu by id
     *
     * @param integer $menuId
     * @param boolean $returnObject
     *
     * @return array
     * @throws \Vein\Core\Exception
     */
    public function get($menuId, $returnObject = false)
    {
        $result = $this->_menuModel->findFirst($menuId);

        if (!$result) {
            throw new \Vein\Core\Exception('Menu with id \'' . $menuId . '\' not found');
        }
        if ($returnObject) {
            return $result;
        }

        return $result->toArray();
    }

    /**
     * Return menu options
     *
     * @return array
     */
    public function getMenuOptions()
    {
        $itemGrid = $this->getCoreItemGrid();
        $itemGrid->setParam('menu', 1);
        $itemGrid->setLimit(100);
        $rows = $itemGrid->getData();

        return $this->_createTree($rows['data'], 'parent_id', 'id');
    }

    /**
     * Create multi array tree structure from linear array.
     *
     * @param array $rows
     * @param string $parent
     * @param string $id
     * @return array
     */
    protected function _createTree($rows, $parent = 'parent_id', $id = 'id')
    {
        $acl = $this->getDi()->get('acl');
        $viewer = $this->getDi()->get('viewer');
        $rs = [];
        foreach ($rows as $row) {
            if ($row['module'] && $row['controller']) {
                if (
                    !$acl->isAllowed($viewer->getRole(), \Vein\Core\Acl\Dispatcher::ACL_ADMIN_MODULE, \Vein\Core\Acl\Dispatcher::ACL_ADMIN_CONTROLLER, '*') &&
                    !$acl->isAllowed($viewer->getRole(), \Vein\Core\Acl\Dispatcher::ACL_ADMIN_MODULE, \Vein\Core\Acl\Dispatcher::ACL_ADMIN_CONTROLLER, 'read')
                ) {
                    if (!$acl->isAllowed($viewer->getRole(), $row['module'], $row['controller'], 'read')) {
                        continue;
                    }
                }
                $row['link'] = '/admin/grid/'.lcfirst(\Phalcon\Text::camelize($row['module'])).'/'.str_replace('-', '/', $row['controller']);
                $row['moduleName'] = \Phalcon\Text::camelize($row['module']);
                $row['controllerName'] = \Phalcon\Text::camelize($row['controller']);
            }
            $rs[$row[$parent]][] = $row;
        }

        return $this->_recursiveTree($rs, 0, $id);
    }

    /**
     *
     *
     * @param array $rs
     * @param int $parent
     * @param string $id
     * @return array
     */
    protected function _recursiveTree(&$rs, $parent = 0, $id = 'id')
    {
        $out = [];
        if (!isset($rs[$parent])) {
            return $out;
        }

        foreach ($rs[$parent] as $row) {
            $row['children' ] = $this->_recursiveTree($rs, $row[$id]);
            $out[$row[$id]] = $row;
        }

        return $out;
    }

}
