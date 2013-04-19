<?php

class Default_Form_Registracion extends Zend_Form
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

        $password = new Zend_Form_Element_Password('password');
        $password->setAttrib('id', 'password');
        $password->setLabel('Contraseña');
        $password->setRequired();
        $password->addValidator('StringLength', true, array ('min' => 3, 'max' => 255));
        $password->setRenderPassword(true);

        $sndPassword = new Zend_Form_Element_Password('sndPassword');
        $sndPassword->setAttrib('id', 'sndPassword');
        $sndPassword->setLabel('Repetir contraseña');
        $sndPassword->setRequired();
        $sndPassword->addValidator('StringLength', true, array ('min' => 3, 'max' => 255));
        $sndPassword->setRenderPassword(true);
        $sndPassword->setErrorMessages(array ('Las contraseñas ingresadas no coinciden'));

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
        $cohorte->addValidator(new Zend_Validate_GreaterThan(0));
        $cohorte->setErrorMessages(array ('Debe indicar una año de ingreso'));

        $date = new Zend_Date();
        $currentYear = $date->toString(Zend_Date::YEAR);
        while ($currentYear > 2006) {
            $cohorte->addMultiOption($currentYear, $currentYear);
            $currentYear--;
        }

        // Captcha
        $recaptchaKeys = Zend_Registry::get('recaptcha');
        $public = $recaptchaKeys['public'];
        $private = $recaptchaKeys['private'];
        $recaptcha = new Zend_Service_ReCaptcha($public, $private, NULL, array ('theme' => 'white', 'lang' => 'es'));

        $captcha = new Zend_Form_Element_Captcha('captcha', array ('captcha' => 'ReCaptcha', 'captchaOptions' => array ('captcha' => 'ReCaptcha', 'service' => $recaptcha)));
        $captcha->setErrorMessages(array ('Debe ingresar el texto que aparece en la imagen'));

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Registrarse');

        $this->addElements(array (
            $email,
            $password,
            $sndPassword,
            $nombre,
            $apellido,
            $cohorte,
            $captcha,
            $submit)
        );
    }

    public function isValid ($data)
    {
        $this->sndPassword->addValidator(new Zend_Validate_Identical($data['password']));

        return parent::isValid($data);
    }

}

