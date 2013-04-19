<?php

class IndexController extends Zend_Controller_Action
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
        $curricula = new Default_Model_CurriculaMapper();
        $curriculas = $curricula->fetchByAlumno($this->_userId);

        $materia = new Default_Model_MateriaMapper();
        $materias = $materia->fetchByAnio();

        foreach ($materias as $anios) {
            foreach ($anios as $cuatrimestres) {
                foreach ($cuatrimestres as $asignatura) {
                    $asignatura->setCurricula($curriculas[$asignatura->getId()]);
                }
            }
        }

        $estado = new Default_Model_EstadoMapper();
        $estados = $estado->fetchAll();

        $styles = "";
        foreach ($estados as $x) {
            $styles .= ".{$x->getClass()} {color : {$x->getFontcolor()}; background-color : {$x->getBgcolor()};}\n";
        }

        $this->view->headStyle()->appendStyle($styles);
        
        $this->view->estados = $estados;
        $this->view->anios = $materias;
        $this->view->headScript()->setFile($this->view->baseUrl('/scripts/index.js'));
    }

}
