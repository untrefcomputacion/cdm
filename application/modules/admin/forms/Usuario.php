<?php

class Admin_Form_Usuario extends Zend_Form
{

    public function init ()
    {
        $this->setMethod('post');

        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre->setAttrib('id', 'nombre');
        $nombre->setLabel('Nombre');
        $nombre->setRequired();
        $nombre->setFilters(array ('StringTrim', 'StringToLower'));

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

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Actualizar datos');

        $this->addElements(array (
            $nombre,
            $newPassword,
            $sndNewPassword,
            $currentPassword,
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

