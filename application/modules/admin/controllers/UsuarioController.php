<?php

class Admin_UsuarioController extends Zend_Controller_Action
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
        $usuarioForm = new Admin_Form_Usuario();

        Zend_Session::start();
        $session = new Zend_Session_Namespace('ControlDeMaterias_Admin');

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($usuarioForm->isValid($data)) {

                $values = $usuarioForm->getValues();
                
                $data = array();
                
                if ($values['newPassword'] != '') {
                    $usuario = new Admin_Model_UsuarioMapper();
                    if ($usuario->checkPassword($this->_userId, $values['currentPassword']) instanceof Admin_Model_Usuario) {
                        $data['password'] = md5($values['newPassword']);
                        $usuario->update($data, $this->_userId);
                    } else {
                        $this->view->error = "La contraseña ingresada no es correcta.";
                        $this->view->form = $usuarioForm;
                        return -1;
                    }
                }
            }
        }

        $usuarioForm->nombre->setValue($session->nombre);
        $usuarioForm->newPassword->setValue('');
        $usuarioForm->sndNewPassword->setValue('');
        $usuarioForm->currentPassword->setValue('');

        $this->view->form = $usuarioForm;

        $this->view->headScript()->setFile($this->view->baseUrl('/scripts/adminUsuario.js'));
    }

}

