<?php
// Autoload
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'autoload' . DIRECTORY_SEPARATOR . 'Psr4Autoloader.php' );
$classLoader = \ExternalLogin\Psr4Autoloader::instance();

//Clave Dependencies
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'simplesamlphp' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . '_autoload.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'simplesamlphp' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SAML2' . DIRECTORY_SEPARATOR . 'Constants.php' );
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'simplesamlphp' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'saml' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'StorkMessage.php' );

// Dependencies
require_once( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'M4PLogin' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'bootstrap.php' );

// Own namespaces
if ( ! class_exists( 'ExternalLogin\M4PExternalsLoginCheck' ) ) {
	$classLoader->addNamespace( 'ExternalLogin\LoginClave', dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'class' );
}
