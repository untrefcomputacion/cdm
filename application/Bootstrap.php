<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initAutoload ()
    {
        $this->options = $this->getOptions();
        Zend_Registry::set('recaptcha', $this->options['recaptcha']);
    }

    protected function _initTranslateValidations ()
    {
        $translator = new Zend_Translate(
                        array (
                            'adapter' => 'array',
                            'content' => APPLICATION_PATH . '/../resources/languages',
                            'locale' => 'es',
                            'scan' => Zend_Translate::LOCALE_DIRECTORY
                        )
        );
        Zend_Validate_Abstract::setDefaultTranslator($translator);
    }

}
