<?php

class Default_Model_GetEstado
{

    protected $_alumnoId;
    protected $_materiaId;
    protected $_estadoId;
    protected $_class;

    function __construct (Zend_Db_Table_Row $data = null)
    {
        if ($data !== null) {
            $this->_alumnoId = $data->alumno_id;
            $this->_materiaId = $data->materia_id;
            $this->_estadoId = $data->estado_id;
            $this->_class = $data->class;
        }
    }

    public function getAlumnoId ()
    {
        return $this->_alumnoId;
    }

    public function setAlumnoId ($alumnoId)
    {
        $this->_alumnoId = $alumnoId;
        return $this;
    }

    public function getMateriaId ()
    {
        return $this->_materiaId;
    }

    public function setMateriaId ($materiaId)
    {
        $this->_materiaId = $materiaId;
        return $this;
    }

    public function getEstadoId ()
    {
        return $this->_estadoId;
    }

    public function setEstadoId ($estadoId)
    {
        $this->_estadoId = $estadoId;
        return $this;
    }

    public function getClass ()
    {
        return $this->_class;
    }

    public function setClass ($class)
    {
        $this->_class = $class;
    }

}

