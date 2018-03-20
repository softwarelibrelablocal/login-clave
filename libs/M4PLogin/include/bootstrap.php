<?php

// Autoload
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'autoload' . DIRECTORY_SEPARATOR . 'Psr4Autoloader.php' );
$classLoader = \M4P\Psr4Autoloader::instance();

// Dependencies

// Own namespaces
if ( ! class_exists( 'M4P\M4PLogin\M4PUser' ) ) {
	$classLoader->addNamespace( 'M4P\M4PLogin', dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'class' );
}
