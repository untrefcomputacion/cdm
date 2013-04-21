<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'Zend/Config/Ini.php';

try {
    $configuration = new Zend_Config_Ini(
        APPLICATION_PATH . '/configs/application.ini',
        APPLICATION_ENV,
        array('allowModifications' => true)
    );
} catch (Exception $e) {
    $configuration = new Zend_Config_Ini(
        APPLICATION_PATH . '/configs/application.ini',
        'development',
        array('allowModifications' => true)
    );

    if (file_exists(APPLICATION_PATH . '/configs/local.ini')) {
        $local = new Zend_Config_Ini(
            APPLICATION_PATH . '/configs/local.ini',
            APPLICATION_ENV,
            array('allowModifications' => true)
        );
        $configuration->merge($local);
    }
}

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    $configuration
);

$application->bootstrap()
            ->run();
