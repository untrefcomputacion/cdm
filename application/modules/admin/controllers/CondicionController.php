<?php

class Admin_CondicionController extends Zend_Controller_Action
{

    private $_userId = null;

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
    }

    public function indexAction ()
    {
        // action body
    }

    public function setestadoAction ()
    {
        $this->_helper->layout->setLayout('response');

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $condicion = new Admin_Model_EstadoCondicionMapper();
            $response = $condicion->update(array ('estado_id' => $data['estadoId']), $data['condicionId']);
            if ($response == 1) {
                $this->view->response = array (
                    "error" => "ok",
                    "message" => "Condition {$data['condicionId']} updated with Estado ID {$data['estadoId']}"
                );
            } else {
                $this->view->response = array (
                    "error" => "error",
                    "message" => "Condition {$data['condicionId']} don`t updated with Estado ID {$data['estadoId']}"
                );
            }
        }
    }

}

