<?php

class Default_Model_Curricula
{

    protected $_alumnoId;
    protected $_materiaId;
    protected $_nota;
    protected $_regular;
    protected $_final;

    function __construct (Zend_Db_Table_Row $data = null)
    {
        if ($data !== null) {
            $this->_alumnoId = $data->alumno_id;
            $this->_materiaId = $data->materia_id;
            $this->_regular = $data->regular;
            $this->_final = $data->final;
            $this->_nota = $data->nota;
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

    public function getNota ()
    {
        return $this->_nota;
    }

    public function setNota ($nota)
    {
        $this->_nota = $nota;
        return $this;
    }

    public function getRegular ()
    {
        return $this->_regular;
    }

    public function setRegular ($regular)
    {
        $this->_regular = ($regular !== 0) ? true : false;
        return $this;
    }

    public function getFinal ()
    {
        return $this->_final;
    }

    public function setFinal ($final)
    {
        $this->_final = ($final !== 0) ? true : false;
        return $this;
    }

}
