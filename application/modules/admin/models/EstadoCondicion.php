<?php

class Admin_Model_EstadoCondicion
{

    protected $_id;
    protected $_estadoId;
    protected $_regularCorrelativa;
    protected $_finalCorrelativa;
    protected $_regular;
    protected $_final;

    function __construct (Zend_Db_Table_Row $data = null)
    {
        if ($data !== null) {
            $this->_id = $data->id;
            $this->_estadoId = $data->estado_id;
            $this->_regularCorrelativa = $data->regular_correlativa;
            $this->_finalCorrelativa = $data->final_correlativa;
            $this->_regular = $data->regular;
            $this->_final = $data->final;
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

    public function getEstadoId ()
    {
        return $this->_estadoId;
    }

    public function setEstadoId ($estadoId)
    {
        $this->_estadoId = $estadoId;
        return $this;
    }

    public function getRegularCorrelativa ()
    {
        return $this->_regularCorrelativa;
    }

    public function setRegularCorrelativa ($regularCorrelativa)
    {
        $this->_regularCorrelativa = $regularCorrelativa;
        return $this;
    }

    public function getFinalCorrelativa ()
    {
        return $this->_finalCorrelativa;
    }

    public function setFinalCorrelativa ($finalCorrelativa)
    {
        $this->_finalCorrelativa = $finalCorrelativa;
        return $this;
    }

    public function getRegular ()
    {
        return $this->_regular;
    }

    public function setRegular ($regular)
    {
        $this->_regular = $regular;
        return $this;
    }

    public function getFinal ()
    {
        return $this->_final;
    }

    public function setFinal ($final)
    {
        $this->_final = $final;
        return $this;
    }
    
}

