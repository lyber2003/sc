<?php
/**
 * @namespace
 */
namespace Frontend\Controller;

use Vein\Core\Builder\Model;
use \User\Service\User,
    \User\Model\User as UserModel;

/**
 * Class SearchController
 *
 * @category  Controller
 * @package   Frontend
 *
 * @property \Vein\Core\Acl\Authorizer auth
 * @property \User\Service\User userService
 * @property \User\Form\Login userFormLogin
 */
class UserController extends BaseController
{
    /**
     *
     * @return mixed
     * @Access(allowed)
     */
    public function indexAction($id = null)
    {
        // For now not used cause whole soscredit still working through Yii
        $this->session->set("userId", 0);
    }

    /**
     * Login
     *
     * @return mixed
     * @Access(allowed)
     */

    public function loginsAction()
    {
        $login = [];
        $postParams = $this->request->getPost();
        $getParams = $this->request->get();
        unset($getParams['_url']);
        $queryString = http_build_query($getParams);

        $redirectUrl = $this->request->get('redirect_url') ? $this->request->get('redirect_url') : $this->request->get('redirect');

        $login = [
            'success' => false,
            'error_type' => false,
            'email' => false
        ];
        if (isset($postParams['email']) && isset($postParams['password'])) {
            $login = $this->userService->loginUser($postParams, $getParams, $redirectUrl);
        }

        if ($login['success']) {
            $this->response->redirect($login['redirect'], true);
        }

        $this->view->setVar('success', $login['success']);
        $this->view->setVar('errorType', $login['error_type']);
        $this->view->setVar('errorMessage', $login['message']);
        $this->view->setVar('email', $postParams['email']);
        $this->view->setVar('redirectUrl', $redirectUrl);
        $this->view->setVar('queryString', $queryString);
        $this->view->setMainView('pages/user/login');
    }


    public function loginAction()
    {
        $params = $this->request->getQuery();
        $postParams = $this->request->getPost();

        if (isset($postParams['login']) && isset($postParams['password'])) {

            if ($postParams) {
                $form = $this->userFormLogin;
                $form->initForm();
                if ($form->isValid($postParams) && $this->auth->check($postParams)) {
                    $this->response->redirect('/admin', true, 301);
                    return true;
                } else {
                    //var_dump($form->getMessages(), $this->auth->getMessage());die;
                    $this->view->message = $this->auth->getMessage();
                    $this->view->setVar('errorMessage', $this->auth->getMessage());
                    //echo $this->view->message; die;
                }
            }
        }
    }

    /**
     * Allow a user to signup to the system
     */
    public function signupAction()
    {

        $userId = $this->session->get("userId");

        // calculating current step
        if ($userId == null) {
            $currentStep = 0;
        } else {
            $userservice = $this->userService->get($userId);
            if ($userservice['email'] != null ) {
                $currentStep = 1;
            } else {
                $currentStep = 2;
            }
        }

        //set view and form for current step
        switch($currentStep) {
            case 0:
                $form = new \User\Form\SignUpForm(null,2);
                $this->view->pick('user/signup');
                break;
            case 1:
                $form = new \User\Form\SecondStepForm();
                $this->view->pick('user/secondStep');
                break;
            case 2:
                $form = new \User\Form\ThirdStepForm();
                $this->view->pick('user/thirdStep');
                break;
        }
            var_dump($this->request->getPost());
                //die;
        $this->view->setVar( 'userId', 'userId - ' . $userId);

        if ($this->request->isPost()) {

            $formData = $this->request->getPost();

            if ($form->isValid($formData) != false) {

                $user = new UserModel();
                $user->login = $formData['name'];
                //$user->phone_id = 2;
                $user->email = $formData['email'];
                $user->password_hash = $this->security->hash($formData['password']);
                $user->password_reset_token = $this->security->hash($formData['password']);

                $result = $user->create();
                if ($result) {
                    $this->session->set("userId", $user->id);
                    $this->response->redirect('/user/signup', true);

                }



                var_dump($user->getMessages());
                //die;


            }
            //TODO: to get this array from db
            $allFormsFieldsNames = array('name','cellPhoneNumber','email','password',
                'confirmPassword', 'terms','surname','secondName','passportNS','gender',
                'birthday', 'adressDistinct','adressСommunity','passportIssued',
                'passportIssuedTime','identificationNumber','civilStatus',
                'registrationAdressIndex','postCode','adressStreet','adressHouse','adressRoom');

            foreach ( $allFormsFieldsNames as $fieldName) {
                $this->view->setVar( $fieldName . '_error', $form->getMessagesFor($fieldName));
            }
        }
    }

    /**
     * Allow a user to signup to the system
     */
    public function logoutAction()
    {
        $this->session->set("userId", 0);
        $this->response->redirect('/', true);
    }

    /**
     * Cabinet action
     *
     * @return mixed
     * @Access(allowed)
     */
    public function cabinetAction()
    {

        $this->view->setMainView('pages/frontend/index');


    }
}