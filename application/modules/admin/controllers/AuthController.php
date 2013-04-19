<?php

class Admin_AuthController extends Zend_Controller_Action
{

    public function init ()
    {
        $this->_helper->layout->setLayout('authadmin');
    }

    public function indexAction ()
    {
        $this->_redirect('/admin/auth/login');
    }

    public function loginAction ()
    {
        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias_Admin');

        if (!isset($session->userId)) {

            $loginForm = new Admin_Form_Login();

            if ($session->failedAttempts > 2) {
                // Captcha
                $recaptchaKeys = Zend_Registry::get('recaptcha');
                $public = $recaptchaKeys['public'];
                $private = $recaptchaKeys['private'];
                $recaptcha = new Zend_Service_ReCaptcha($public, $private, NULL, array ('theme' => 'white', 'lang' => 'es'));

                $captcha = new Zend_Form_Element_Captcha('captcha', array ('captcha' => 'ReCaptcha', 'captchaOptions' => array ('captcha' => 'ReCaptcha', 'service' => $recaptcha)));
                $captcha->setOrder(3);
                $captcha->setErrorMessages(array ('Debe ingresar el texto que aparece en la imagen'));
                $loginForm->addElement($captcha);
            }

            if ($this->_request->isPost()) {
                if ($loginForm->isValid($this->_request->getPost())) {

                    $db = Zend_Db_Table::getDefaultAdapter();

                    $authAdapter = new Zend_Auth_Adapter_DbTable($db);
                    $authAdapter->setTableName('usuario');
                    $authAdapter->setIdentityColumn('nombre');
                    $authAdapter->setCredentialColumn('password');
                    $authAdapter->setCredentialTreatment('MD5(?)');

                    $authAdapter->setIdentity($loginForm->getValue('nombre'));
                    $authAdapter->setCredential($loginForm->getValue('password'));

                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);

                    if ($result->isValid()) {

                        $alumno = $authAdapter->getResultRowObject();

                        $session->userId = $alumno->id;
                        $session->nombre = $alumno->nombre;

                        $this->_redirect('/admin');
                        return 0;
                    } else {
                        $session->failedAttempts++;

                        $this->view->error = "El usuario o la contraseña no son correctas.";
                    }
                }
            }

            $this->view->form = $loginForm;
        } else {
            $this->_redirect('/admin');
            return 0;
        }
    }

    public function logoutAction ()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy(true);
        $this->_redirect('/admin/auth/login');
    }

}
