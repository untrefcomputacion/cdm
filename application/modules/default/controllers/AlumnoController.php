<?php

class AlumnoController extends Zend_Controller_Action
{

    private $_userId;

    public function init ()
    {
        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias');
        if (!isset($session->userId)) {
            $this->_redirect('/auth/logout');
            return 0;
        }
        $this->_userId = $session->userId;
        $this->view->nombre = $session->nombre . ' ' . $session->apellido;
    }

    public function indexAction ()
    {
        $alumnoForm = new Default_Form_Alumno();

        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias');

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($alumnoForm->isValid($data)) {

                $alumno = new Default_Model_AlumnoMapper();

                $values = $alumnoForm->getValues();


                $data = array ();

                if ($values['newPassword'] != '') {
                    if ($alumno->checkPassword($this->_userId, $values['currentPassword']) instanceof Default_Model_Alumno) {
                        $data['password'] = md5($values['newPassword']);
                    } else {
                        $this->view->error = "La contraseña ingresada no es correcta.";
                        $this->view->form = $alumnoForm;
                        return -1;
                    }
                }

                $data['email'] = $values['email'];
                $data['nombre'] = mb_convert_case($values['nombre'], MB_CASE_TITLE, "UTF-8");
                $data['apellido'] = mb_convert_case($values['apellido'], MB_CASE_TITLE, "UTF-8");
                $data['cohorte'] = $values['cohorte'];

                $alumno->updateAlumno($data, $this->_userId);

                $session->email = $data['email'];
                $session->nombre = $data['nombre'];
                $session->apellido = $data['apellido'];
                $session->cohorte = $data['cohorte'];

                $alumnoForm->newPassword->setValue('');
                $alumnoForm->sndNewPassword->setValue('');
                $alumnoForm->currentPassword->setValue('');

                $this->view->nombre = $session->nombre . ' ' . $session->apellido;
            }
        } else {
            $alumnoForm->email->setValue($session->email);
            $alumnoForm->newPassword->setValue('');
            $alumnoForm->sndNewPassword->setValue('');
            $alumnoForm->currentPassword->setValue('');
            $alumnoForm->nombre->setValue($session->nombre);
            $alumnoForm->apellido->setValue($session->apellido);
            $alumnoForm->cohorte->setValue($session->cohorte);
        }
        $this->view->form = $alumnoForm;
        
        $this->view->headScript()->setFile($this->view->baseUrl('/scripts/alumno.js'));
    }

}

