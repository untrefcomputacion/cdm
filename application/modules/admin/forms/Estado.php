<?php

class Admin_Form_Estado extends Zend_Form
{

    public function init ()
    {
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->setAttrib('id', 'id');
        $id->setFilters(array ('StringTrim'));
        
        $action = new Zend_Form_Element_Hidden('action');
        $action->setAttrib('id', 'action');
        $action->setFilters(array ('StringTrim'));
        
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setAttrib('id', 'nombre');
        $nombre->setLabel('Nombre');
        $nombre->setRequired();
        $nombre->setFilters(array ('StringTrim'));

        $class = new Zend_Form_Element_Text('class');
        $class->setAttrib('id', 'class');
        $class->setLabel('Clase CSS');
        $class->setRequired();
        $class->setFilters(array ('StringTrim'));

        $bgcolor = new Zend_Form_Element_Text('bgcolor');
        $bgcolor->setAttrib('id', 'bgcolor');
        $bgcolor->setLabel('Color de fondo');
        $bgcolor->setRequired();
        $bgcolor->setFilters(array ('StringTrim'));

        $fontcolor = new Zend_Form_Element_Text('fontcolor');
        $fontcolor->setAttrib('id', 'fontcolor');
        $fontcolor->setLabel('Color de fuente');
        $fontcolor->setRequired();
        $fontcolor->setFilters(array ('StringTrim'));

        $descripcion = new Zend_Form_Element_Text('descripcion');
        $descripcion->setAttrib('id', 'descripcion');
        $descripcion->setLabel('Descripción');
        $descripcion->setRequired();
        $descripcion->setFilters(array ('StringTrim'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Crear estado');
        
        $delete = new Zend_Form_Element_Submit('delete');
        $delete->setLabel("Eliminar estado");

        $cancel = new Zend_Form_Element_Button('reset');
        $cancel->setLabel('Cancelar');

        $this->addElements(array (
            $id,
            $action,
            $nombre,
            $class,
            $bgcolor,
            $fontcolor,
            $descripcion,
            $submit,
            $delete,
            $cancel)
        );

        $this->setAttrib('id', 'estado');
    }

}

