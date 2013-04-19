<?php

class Admin_Form_Login extends Zend_Form
{

    public function init ()
    {
        $this->setMethod('post');

        $email = new Zend_Form_Element_Text('nombre');
        $email->setAttrib('id', 'nombre');
        $email->setLabel('Nombre de usuario');
        $email->setRequired();
        $email->setFilters(array ('StringTrim', 'StringToLower'));
        $email->setOrder(1);

        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('id', 'password');
        $password->setLabel('Contraseña');
        $password->setRequired();
        $password->addValidator('StringLength', true, array ('min' => 3, 'max' => 255));
        $password->setRenderPassword(true);
        $password->setorder(2);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Iniciar sesión');
        $submit->setOrder(4);

        $this->addElements(array (
            $email,
            $password,
            $submit)
        );
    }

}

