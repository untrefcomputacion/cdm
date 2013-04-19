<?php

class Admin_AlumnoController extends Zend_Controller_Action
{

    private $_userId;

    public function init ()
    {
        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias_Admin');
        if (!isset($session->userId)) {
            $this->_redirect('/admin/auth/logout');
            return 0;
        }
        $this->_userId = $session->userId;
        $this->view->nombre = $session->nombre;

        $this->_helper->layout->setLayout('layoutadmin');
    }

    public function indexAction ()
    {
        $alumno = new Admin_Model_AlumnoMapper();
        $this->view->alumnos = $alumno->fetchAll();
    }

}

