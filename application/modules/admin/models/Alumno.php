<?php

class Admin_Model_Alumno
{

    protected $_id;
    protected $_email;
    protected $_nombre;
    protected $_apellido;
    protected $_cohorte;

    function __construct (Zend_Db_Table_Row $data = null)
    {
        if ($data !== null) {
            $this->_id = $data->id;
            $this->_email = $data->email;
            $this->_nombre = $data->nombre;
            $this->_apellido = $data->apellido;
            $this->_cohorte = $data->cohorte;
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

    public function getEmail ()
    {
        return $this->_email;
    }

    public function setEmail ($email)
    {
        $this->_email = $email;
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

    public function getApellido ()
    {
        return $this->_apellido;
    }

    public function setApellido ($apellido)
    {
        $this->_apellido = $apellido;
        return $this;
    }

    public function getCohorte ()
    {
        return $this->_cohorte;
    }

    public function setCohorte ($cohorte)
    {
        $this->_cohorte = $cohorte;
        return $this;
    }

    public function __toString ()
    {
        return $this->_nombre . " " . $this->apellido;
    }

}
