<?php
/**
 * SAML 2.0 remote IdP metadata for simpleSAMLphp.
 *
 * Remember to remove the IdPs you don't use from this file.
 *
 * See: https://rnd.feide.no/content/idp-remote-metadata-reference
 */


$metadata['ES'] = array(
	'name' => array(
		'en' => 'ES',
		'pt' => 'ES',
	),
	'SingleSignOnService' => StorkConstants::get_login_send_url(),
	'certFingerprint' => 'e6c35454c1c4cf873abcb01baeee10e73e0136fe',
	'sign.authnrequest' => TRUE,
//	'redirect.sign' => TRUE,
	'redirect.validate' => TRUE
);
