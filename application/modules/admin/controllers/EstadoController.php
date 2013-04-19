<?php

class Admin_EstadoController extends Zend_Controller_Action
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
        $estadoForm = new Admin_Form_Estado();

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($estadoForm->isValid($data)) {

                $data = $estadoForm->getValues();
                $estado = new Admin_Model_EstadoMapper();

                switch ($data['action']) {
                    case 'create':
                        $response = $estado->insert(array (
                                    'nombre' => $data['nombre'],
                                    'class' => $data['class'],
                                    'bgcolor' => $data['bgcolor'],
                                    'fontcolor' => $data['fontcolor'],
                                    'descripcion' => $data['descripcion']
                                ));
                        $estadoForm->reset();
                        break;
                    case 'update':
                        $response = $estado->update(array (
                                    'nombre' => $data['nombre'],
                                    'class' => $data['class'],
                                    'bgcolor' => $data['bgcolor'],
                                    'fontcolor' => $data['fontcolor'],
                                    'descripcion' => $data['descripcion']
                                        ), $data['id']);
                        $estadoForm->reset();
                        break;
                    case 'delete':
                        $response = $estado->delete($data['id']);
                        $estadoForm->reset();
                        break;
                }
            }
        }

        $this->view->form = $estadoForm;

        $estados = new Admin_Model_EstadoMapper();
        $this->view->estados = $estados->fetchAll();

        $condiciones = new Admin_Model_EstadoCondicionMapper();
        $this->view->condiciones = $condiciones->fetchAll();


        $this->view->headLink()->setStylesheet($this->view->baseUrl('/style/colorpicker.css'));
        $this->view->headScript()->setFile($this->view->baseUrl('/scripts/colorpicker.js'));
        $this->view->headScript()->appendFile($this->view->baseUrl('/scripts/adminEstado.js'));
    }

}

