<?php

class AuthController extends Zend_Controller_Action
{

    public function init ()
    {
        $this->_helper->layout->setLayout('auth');
    }

    public function indexAction ()
    {
        $this->_redirect('/auth/logout');
    }

    public function loginAction ()
    {
        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias');

        if (!isset($session->userId)) {

            $loginForm = new Default_Form_Login();

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
                    $authAdapter->setTableName('alumno');
                    $authAdapter->setIdentityColumn('email');
                    $authAdapter->setCredentialColumn('password');
                    $authAdapter->setCredentialTreatment('MD5(?)');

                    $authAdapter->setIdentity($loginForm->getValue('email'));
                    $authAdapter->setCredential($loginForm->getValue('password'));

                    $auth = Zend_Auth::getInstance();
                    $result = $auth->authenticate($authAdapter);

                    if ($result->isValid()) {

                        $alumno = $authAdapter->getResultRowObject();

                        $session->userId = $alumno->id;
                        $session->email = $alumno->email;
                        $session->cohorte = $alumno->cohorte;
                        $session->nombre = $alumno->nombre;
                        $session->apellido = $alumno->apellido;

                        $this->_redirect('/');
                        return 0;
                    } else {
                        $session->failedAttempts++;

                        $this->view->error = "El usuario o la contraseña no son correctas.";
                    }
                }
            }

            $this->view->form = $loginForm;
        } else {
            $this->_redirect('/');
            return 0;
        }
    }

    public function registracionAction ()
    {
        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias');

        if (!isset($session->userId)) {

            $registracionForm = new Default_Form_Registracion();

            if ($this->_request->isPost()) {
                $data = $this->_request->getPost();
                if ($registracionForm->isValid($data)) {

                    $alumno = new Default_Model_AlumnoMapper();

                    $data = $registracionForm->getValues();

                    try {
                        $alumnoId = $alumno->createAlumno(array (
                                    'email' => $data['email'],
                                    'password' => md5($data['password']),
                                    'cohorte' => $data['cohorte'],
                                    'nombre' => mb_convert_case($data['nombre'], MB_CASE_TITLE, "UTF-8"),
                                    'apellido' => mb_convert_case($data['apellido'], MB_CASE_TITLE, "UTF-8")
                                ));

                        $materia = new Default_Model_MateriaMapper();
                        $materiasId = $materia->getIds();

                        $curricula = new Default_Model_CurriculaMapper();

                        $curricula->initAlumno($alumnoId, $materiasId);

                        $this->_redirect('/auth/logout');
                        return 0;
                    }
                    catch (Exception $exc) {
                        if ($exc->getCode() == 23000) {
                            $this->view->error = "Ya existe un usuario que esta utilizando el email '{$data['email']}'.";
                        }
                    }
                }
            }

            $this->view->form = $registracionForm;
        } else {
            $this->_redirect('/');
            return 0;
        }
    }

    public function logoutAction ()
    {
        Zend_Auth::getInstance()->clearIdentity();
        Zend_Session::destroy(true);
        $this->_redirect('/auth/login');
    }

}
