<?php

class MateriaController extends Zend_Controller_Action
{

    private $_userId = null;

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
        
    }

    public function getestadoAction ()
    {
        $this->_helper->layout->setLayout('response');

        $estados = new Default_Model_GetEstadoMapper();
        $this->view->response = $estados->fetchByAlumnoId($this->_userId);
    }

    public function setregularAction ()
    {
        $this->_helper->layout->setLayout('response');

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $curricula = new Default_Model_CurriculaMapper();
            $response = $curricula->update(array ('regular' => $data['value']), $this->_userId, $data['id']);
            if ($response == 1) {
                $estados = new Default_Model_GetEstadoMapper();
                $this->view->response = $estados->fetchByAlumnoId($this->_userId);
            } else {
                $this->view->response = array (
                    "error" => "error",
                    "message" => "Materia {$data['id']}  don't updated with Regular {$data['value']}"
                );
            }
        }
    }

    public function setfinalAction ()
    {
        $this->_helper->layout->setLayout('response');

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $curricula = new Default_Model_CurriculaMapper();
            $response = $curricula->update(array ('final' => $data['value']), $this->_userId, $data['id']);
            if ($response == 1) {
                $estados = new Default_Model_GetEstadoMapper();
                $this->view->response = $estados->fetchByAlumnoId($this->_userId);
            } else {
                $this->view->response = array (
                    "error" => "error",
                    "message" => "Materia {$data['id']}  don't updated with Final {$data['value']}"
                );
            }
        }
    }

    public function setnotaAction ()
    {
        $this->_helper->layout->setLayout('response');

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $curricula = new Default_Model_CurriculaMapper();

            $response = $curricula->update(array ('nota' => ($data['value']) ? $data['value'] : null), $this->_userId, $data['id']);
            if ($response == 1) {
                $this->view->response = array (
                    "error" => "ok",
                    "message" => "Materia {$data['id']} updated with Nota {$data['value']}"
                );
            } else {
                $this->view->response = array (
                    "error" => "error",
                    "message" => "Materia {$data['id']}  don't updated with Nota {$data['value']}"
                );
            }
        }
    }

}

