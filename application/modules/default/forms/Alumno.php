<?php

class Default_Form_Alumno extends Zend_Form
{

    public function init ()
    {
        $this->setMethod('post');

        $email = new Zend_Form_Element_Text('email');
        $email->setAttrib('id', 'email');
        $email->setLabel('Email');
        $email->setRequired();
        $email->setFilters(array ('StringTrim', 'StringToLower'));
        $email->setValidators(array ('EmailAddress'));

        $newPassword = new Zend_Form_Element_Password('newPassword');
        $newPassword->setAttrib('id', 'newPassword');
        $newPassword->setLabel('Contraseña nueva');
        $newPassword->addValidator('StringLength', true, array ('min' => 3, 'max' => 255));
        $newPassword->setRenderPassword(true);

        $sndNewPassword = new Zend_Form_Element_Password('sndNewPassword');
        $sndNewPassword->setAttrib('id', 'sndNewPassword');
        $sndNewPassword->setLabel('Repetir contraseña');
        $sndNewPassword->addValidator('StringLength', true, array ('min' => 3, 'max' => 255));
        $sndNewPassword->setRenderPassword(true);

        $currentPassword = new Zend_Form_Element_Password('currentPassword');
        $currentPassword->setAttrib('id', 'currentPassword');
        $currentPassword->setLabel('Contraseña actual');
        $currentPassword->addValidator('StringLength', true, array ('min' => 3, 'max' => 255));
        $currentPassword->setRenderPassword(true);

        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setAttrib('id', 'nombre');
        $nombre->setLabel('Nombre');
        $nombre->setRequired();
        $nombre->setFilters(array ('StringTrim'));

        $apellido = new Zend_Form_Element_Text('apellido');
        $apellido->setAttrib('id', 'apellido');
        $apellido->setLabel('Apellido');
        $apellido->setRequired();
        $apellido->setFilters(array ('StringTrim'));

        $cohorte = new Zend_Form_Element_Select('cohorte');
        $cohorte->setAttrib('id', 'cohorte');
        $cohorte->setLabel('Cohorte');
        $cohorte->setRequired();
        $cohorte->addMultiOption(0, '');

        $date = new Zend_Date();
        $currentYear = $date->toString(Zend_Date::YEAR);
        while ($currentYear > 2006) {
            $cohorte->addMultiOption($currentYear, $currentYear);
            $currentYear--;
        }

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Actualizar datos');

        $this->addElements(array (
            $email,
            $newPassword,
            $sndNewPassword,
            $currentPassword,
            $nombre,
            $apellido,
            $cohorte,
            $submit)
        );
    }

    public function isValid ($data)
    {
        if ($data['newPassword'] !== '') {
            $this->currentPassword->setRequired();
            
            $this->sndNewPassword->setRequired();
            $this->sndNewPassword->addValidator(new Zend_Validate_Identical($data['newPassword']));
        }

        return parent::isValid($data);
    }

}

