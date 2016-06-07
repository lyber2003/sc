<?php
/**
 * @namespace
 */
namespace Admin\Controller;

use Phalcon\Mvc\View;

/**
 * @RoutePrefix("/admin", name="admin")
 * 
 * @property \Vein\Core\Acl\Authorizer auth
 */
class AdminController extends Base
{

    /**
     * @Route("/", methods={"GET"}, name="home")
     */
    public function indexAction()
    {
        //parent::initialize();
        $modules = [];
        foreach ($this->modules as $module => $status) {
            if ($status) {
                $modules[] = ucfirst($module);
            }
        }

        $this->view->title = 'SosCredit admin panel';
        $this->view->menus = $this->coreMenuService->getMenuOptions();
        $this->view->username = $this->userAuth->getUserName();
        $this->view->modules = $modules;
        $this->view->pick('admin/dashboard');
    }

    /**
     * @Route("/login", methods={"GET"}, name="login-form")
     * @Access(allowed)
     */
    public function loginAction()
    {
        $this->view->title = 'SosCredit admin panel';
        $form = $this->userFormLogin;
        //$this->view->pick('admin/login');
    }

    /**
     * @Route("/auth", methods={"POST"}, name="login-auth")
     * @Access(allowed)
     */
    public function authAction()
    {
        $params = $this->request->getPost();

        $result = ['success' => false];

        if ($this->auth->check($params)) {
            $this->response->redirect('/admin', true, 301);
            return true;
        } else {
            $result['msg'] = $this->auth->getMessage();
        }

        $this->response->redirect('/admin/login', true, 301);

        return true;
    }

    /**
     * @Route("/check", methods={"POST"}, name="login-check")
     * @Access(allowed)
     */
    public function checkAction()
    {
        $params = $this->request->getPost();
        $result = ['success' => false];

        if ($this->auth->checkRememberMe($params['token'])) {
            if (!$this->viewer->getId()) {
                $this->auth->loginWithRememberMe();
            }
            if ($this->userAuth->checkAdminAccess()) {
                $result['success'] = true;
            } else {
                $result['msg'] = "Access denied";
            }
        } else {
            $result['msg'] = $this->auth->getMessage();
        }
        echo json_encode($result);

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    /**
     * @Route("/logout", methods={"GET"}, name="logout")
     */
    public function logoutAction()
    {
        $result = ['success' => false];

        if ($this->auth->isAuth() && $this->auth->remove()) {
            $result['success'] = true;
        } else {
            $result['msg'] = $this->auth->getMessage();
        }
        echo json_encode($result);

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    /**
     * @Route("/isauth", methods={"GET"}, name="isauth")
     */
    public function isauthAction()
    {
        $result = ['success' => false];

        if ($this->auth->isAuth()) {
            if ($this->_checkAccess()) {
                $result['success'] = true;
            } else {
                $result['msg'] = "Access denied";
            }
        } else {
            $result['msg'] = $this->auth->getMessage();
        }
        echo json_encode($result);

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

    /**
     * @Route("/menu/denied", methods={"GET"}, name="denied")
     * @Access(allowed)
     */
    public function deniedAction()
    {
        $result = ['success' => false, 'msg' => 'Access denied'];
        echo json_encode($result);

        $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
    }

}

