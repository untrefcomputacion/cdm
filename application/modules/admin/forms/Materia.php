<?php

class Admin_Form_Materia extends Zend_Form
{

    public function init ()
    {

        $id = new Zend_Form_Element_Text('id');
        $id->setAttrib('id', 'id');
        $id->setLabel('Id');
        $id->setRequired();
        $id->setValidators(array ('Int'));
        $id->setFilters(array ('StringTrim'));

        $action = new Zend_Form_Element_Hidden('action');
        $action->setAttrib('id', 'action');
        $action->setFilters(array ('StringTrim'));

        $anio = new Zend_Form_Element_Text('anio');
        $anio->setAttrib('id', 'anio');
        $anio->setLabel('Año');
        $anio->setRequired();
        $anio->setValidators(array ('Int'));
        $anio->setFilters(array ('StringTrim'));

        $cuatrimestre = new Zend_Form_Element_Text('cuatrimestre');
        $cuatrimestre->setAttrib('id', 'cuatrimestre');
        $cuatrimestre->setLabel('Cuatrimestre');
        $cuatrimestre->setRequired();
        $cuatrimestre->setValidators(array ('Int'));
        $cuatrimestre->setFilters(array ('StringTrim'));

        $codigo = new Zend_Form_Element_Text('codigo');
        $codigo->setAttrib('id', 'codigo');
        $codigo->setLabel('Código');
        $codigo->setValidators(array ('Int'));
        $codigo->setFilters(array ('StringTrim'));

        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setAttrib('id', 'nombre');
        $nombre->setLabel('Nombre');
        $nombre->setRequired();
        $nombre->setFilters(array ('StringTrim'));

        $horas = new Zend_Form_Element_Text('horas');
        $horas->setAttrib('id', 'horas');
        $horas->setLabel('Carga horaria');
        $horas->setRequired();
        $horas->setValidators(array ('Int'));
        $horas->setFilters(array ('StringTrim'));

        $correlativa = new Zend_Form_Element_Select('correlativa');
        $correlativa->setAttrib('id', 'correlativa');
        $correlativa->setLabel('Correlativa');
        $correlativa->setRequired();

        $materia = new Admin_Model_MateriaMapper();
        $materias = $materia->fetchAll();
        foreach ($materias as $asignatura) {
            $correlativa->addMultiOption($asignatura->getId(), '(' . $asignatura->getCodigo() . ') ' . $asignatura->getNombre());
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Crear materia');

        $delete = new Zend_Form_Element_Submit('delete');
        $delete->setLabel("Eliminar materia");

        $cancel = new Zend_Form_Element_Button('reset');
        $cancel->setLabel('Cancelar');

        $this->addElements(array (
            $id,
            $action,
            $anio,
            $cuatrimestre,
            $codigo,
            $nombre,
            $horas,
            $correlativa,
            $submit,
            $delete,
            $cancel)
        );

        $this->setAttrib('id', 'materia');
    }

}
