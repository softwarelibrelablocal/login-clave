<?php

/**
 * Class for SAML 2 authentication request messages.
 *
 * @package simpleSAMLphp
 * @version $Id$
 */
class SAML2_StorkAuthnRequest extends SAML2_AuthnRequest {

	/**
	 * Constructor for SAML 2 authentication request messages.
	 *
	 * @param DOMElement|NULL $xml The input message.
	 *
	 * @throws Exception
	 */
	public function __construct( DOMElement $xml = null ) {
		parent::__construct();
	}

	/**
	 * Convert this authentication request to an XML element.
	 *
	 * @return DOMElement  This authentication request.
	 */
	public function toUnsignedXML() {
		$root = parent::toUnsignedXML();
		/* Ugly hack to add another namespace declaration to the root element. */
		//$root->setAttributeNS('urn:eu:stork:names:tc:STORK:1.0:protocol', 'storkp:tmp', 'tmp');
		//$root->removeAttributeNS('urn:eu:stork:names:tc:STORK:1.0:protocol', 'tmp');
		//$root->setAttributeNS('urn:eu:stork:names:tc:STORK:1.0:assertion', 'stork:tmp', 'tmp');
		//$root->removeAttributeNS('urn:eu:stork:names:tc:STORK:1.0:assertion', 'tmp');

		$assertionUrl = StorkConstants::getAssertionUrl();

		$root->setAttribute( 'AssertionConsumerServiceURL', $assertionUrl );
		$root->setAttribute( 'ProviderName', StorkConstants::get_spname() );

		$exts = $this->getExtensions();
		if ( ! empty( $exts ) ) {
			$root->appendChild( $exts );
		}

		return $root;
	}

	public function setExtensions( $extensions ) {
		assert( 'is_array($extensions)' );
		$this->extensions = $extensions;
	}

	/**
	 * Get the Extensions.
	 *
	 * @param array|NULL $extensions The Extensions.
	 */
	public function getExtensions() {
		$extension = $this->document->createElementNS( StorkConstants::SAMLP_NS, 'samlp:Extensions' );

		//fixme: revisar este acceso
		foreach ( $this->extensions as $key => $value ) {
			if ( $key === "RequestedAttributes" ) {
				$attrs = $this->document->createElementNS( StorkConstants::STORKP_NS, 'storkp:RequestedAttributes' );
				foreach ( $value as $attr ) {
					$attrs->appendChild( $attr->toDOM( $this->document ) );
				}
				$extension->appendChild( $attrs );
			} else if ( $key === "VIDP" ) {
				$vidp = $this->document->createElementNS( StorkConstants::STORKP_NS, 'storkp:VIDPAuthenticationAttributes' );
				SAML2_Utils::addString( $vidp, StorkConstants::STORKP_NS, 'storkp:CitizenCountryCode', $value['country'] );
				$spinfo = $this->document->createElementNS( StorkConstants::STORKP_NS, 'storkp:SPInformation' );
				SAML2_Utils::addString( $spinfo, StorkConstants::STORKP_NS, 'storkp:SPID', $value['spid'] );
				$vidp->appendChild( $spinfo );
				$extension->appendChild( $vidp );
			} else {
				$ns = null;
				if ( strpos( $key, 'storkp:' ) === 0 ) {
					$ns = StorkConstants::STORKP_NS;
				} else if ( strpos( $key, 'stork:' ) === 0 ) {
					$ns = StorkConstants::STORK_NS;
				} else {
					SimpleSAML_Logger::error( "THIS SHOULND'T HAPPEN!!\nCaused by key: " . $key );
				}
				SAML2_Utils::addString( $extension, $ns, $key, $value );
			}
		}


		SimpleSAML_Logger::debug( $extension->ownerDocument->saveXML() );

		return $extension;
	}


}


