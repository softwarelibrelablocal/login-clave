<?php

$settings = new \ExternalLogin\LoginClave\M4PClaveSettings();

$config = array(

	// This is a authentication source which handles admin authentication.
	'admin' => array(
		// The default is to use core:AdminPassword, but it can be replaced with
		// any authentication source.

		'core:AdminPassword',
	),

	$settings->get_spname()=> array(
		'saml:SP',
		'certificate' => $settings->get_certificate(),
		'validate.certificate' => $settings->get_validate_certificate(),
		'privatekey' => $settings->get_privatekey(),
		'privatekey_pass' =>$settings->get_privatekey_pass(),
		'name' => array(
			'en' => $settings->get_spname(),
			'pt' => $settings->get_spname(),
		),
		'attributes.NameFormat' => 'urn:oasis:names:tc:SAML:2.0:attrname-format:uri',
		'sign.authnrequest' => TRUE,
		'sign.logout' => TRUE,
	//	'redirect.sign' => TRUE,
	),

	// An authentication source which can authenticate against both SAML 2.0
	// and Shibboleth 1.3 IdPs.
	'default-sp' => array(
		'saml:SP',

		// The entity ID of this SP.
		// Can be NULL/unset, in which case an entity ID is generated based on the metadata URL.
		'entityID' => NULL,

		// The entity ID of the IdP this should SP should contact.
		// Can be NULL/unset, in which case the user will be shown a list of available IdPs.
		'idp' => NULL,

		// The URL to the discovery service.
		// Can be NULL/unset, in which case a builtin discovery service will be used.
		'discoURL' => NULL,
	),

);
