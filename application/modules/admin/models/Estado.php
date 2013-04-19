<?php

class Admin_Model_Estado
{

    protected $_id;
    protected $_nombre;
    protected $_class;
    protected $_bgcolor;
    protected $_fontcolor;
    protected $_descripcion;

    function __construct (Zend_Db_Table_Row $data = null)
    {
        if ($data !== null) {
            $this->_id = $data->id;
            $this->_nombre = $data->nombre;
            $this->_class = $data->class;
            $this->_bgcolor = $data->bgcolor;
            $this->_fontcolor = $data->fontcolor;
            $this->_descripcion = $data->descripcion;
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

    public function getNombre ()
    {
        return $this->_nombre;
    }

    public function setNombre ($nombre)
    {
        $this->_nombre = $nombre;
        return $this;
    }

    public function getClass ()
    {
        return $this->_class;
    }

    public function setClass ($class)
    {
        $this->_class = $class;
        return $this;
    }

    public function getBgcolor ()
    {
        return $this->_bgcolor;
    }

    public function setBgcolor ($bgcolor)
    {
        $this->_bgcolor = $bgcolor;
        return $this;
    }

    public function getFontcolor ()
    {
        return $this->_fontcolor;
    }

    public function setFontcolor ($fontcolor)
    {
        $this->_fontcolor = $fontcolor;
        return $this;
    }

    public function getDescripcion ()
    {
        return $this->_descripcion;
    }

    public function setDescripcion ($descripcion)
    {
        $this->_descripcion = $descripcion;
        return $this;
    }
    
    public function __toString ()
    {
        return $this->_nombre;
    }

}

