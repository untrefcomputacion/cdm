<?php

class Admin_MateriaController extends Zend_Controller_Action
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

        $materiaForm = new Admin_Form_Materia();

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($materiaForm->isValid($data)) {

                $data = $materiaForm->getValues();
                $materia = new Admin_Model_MateriaMapper();

                switch ($data['action']) {
                    case 'create':
                        try {
                            $response = $materia->insert(array (
                                        'id' => $data['id'],
                                        'codigo' => $data['codigo'],
                                        'nombre' => $data['nombre'],
                                        'anio' => $data['anio'],
                                        'cuatrimestre' => $data['cuatrimestre'],
                                        'correlativa' => $data['correlativa'],
                                        'horas' => $data['horas']
                                    ));
                            $materiaForm->reset();
                        }
                        catch (Exception $exc) {
                            if ($exc->getCode() == 23000) {
                                $this->view->error = "Ya existe una materia con el Id '{$data['id']}'.";
                            } else {
                                $this->view->error = $exc->getMessage();
                            }
                        }
                        break;
                    case 'update':
                        $response = $materia->update(array (
                                    'codigo' => $data['codigo'],
                                    'nombre' => $data['nombre'],
                                    'anio' => $data['anio'],
                                    'cuatrimestre' => $data['cuatrimestre'],
                                    'correlativa' => $data['correlativa'],
                                    'horas' => $data['horas']
                                        ), $data['id']);
                        $materiaForm->reset();
                        break;
                    case 'delete':
                        try {
                            $response = $materia->delete($data['id']);
                            $materiaForm->reset();
                        }
                        catch (Exception $exc) {
                            if ($exc->getCode() == 23000) {
                                $this->view->error = "No puede eliminar una materia que sea corelativa de otra.<br />Primero debe eliminar las referencias";
                            } else {
                                $this->view->error = $exc->getMessage();
                            }
                        }
                        break;
                }
            }
        }

        $this->view->form = $materiaForm;

        $materia = new Admin_Model_MateriaMapper();
        $this->view->materias = $materia->fetchAll();

        $this->view->headScript()->appendFile($this->view->baseUrl('/scripts/adminMateria.js'));
    }

    public function fixAction ()
    {
        $a = new Default_Model_MateriaMapper();
        $a->fixEncoding();
    }

}

