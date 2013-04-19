<?php

class Default_Model_Materia
{

    protected $_id;
    protected $_codigo;
    protected $_nombre;
    protected $_anio;
    protected $_cuatrimestre;
    protected $_correlativa;
    protected $_horas;
    protected $_curricula;

    function __construct (Zend_Db_Table_Row $data = null)
    {
        if ($data !== null) {
            $this->_id = $data->id;
            $this->_codigo = $data->codigo;
            $this->_nombre = $data->nombre;
            $this->_anio = $data->anio;
            $this->_cuatrimestre = $data->cuatrimestre;
            $this->_correlativa = $data->correlativa;
            $this->_horas = $data->horas;
        }
    }

    public function getId ()
    {
        return $this->_id;
    }

    public function setId ($id)
    {
        $this->_id = $id;
        return $this;
    }

    public function getCodigo ()
    {
        return $this->_codigo;
    }

    public function setCodigo ($codigo)
    {
        $this->_codigo = $codigo;
        return $this;
    }

    public function getNombre ()
    {
        return $this->_nombre;
    }

    public function setNombre ($nombre)
    {
        $this->_nombre = $nombre;
        return $this;
    }

    public function getAnio ()
    {
        return $this->_anio;
    }

    public function setAnio ($anio)
    {
        $this->_anio = $anio;
        return $this;
    }

    public function getCuatrimestre ()
    {
        return $this->_cuatrimestre;
    }

    public function setCuatrimestre ($cuatrimestre)
    {
        $this->_cuatrimestre = $cuatrimestre;
        return $this;
    }

    public function getCorrelativa ()
    {
        return $this->_correlativa;
    }

    public function setCorrelativa ($correlativa)
    {
        $this->_correlativa = $correlativa;
        return $this;
    }

    public function getHoras ()
    {
        return $this->_horas;
    }

    public function setHoras ($horas)
    {
        $this->_horas = $horas;
        return $this;
    }

    public function getCurricula ()
    {
        return $this->_curricula;
    }

    public function setCurricula ($curricula)
    {
        $this->_curricula = $curricula;
        return $this;
    }
    
    public function __toString ()
    {
        return $this->_nombre;
    }

}

