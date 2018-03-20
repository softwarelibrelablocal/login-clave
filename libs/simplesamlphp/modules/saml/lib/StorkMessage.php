<?php


/**
 * Common code for building SAML 2 messages based on the
 * available metadata.
 *
 * @package simpleSAMLphp
 * @version $Id$
 */
class stork_saml_Message extends sspmod_saml_Message {

	/**
	 * Build an authentication request based on information in the metadata.
	 *
     * @param SimpleSAML_Configuration $extensions
	 * @param SimpleSAML_Configuration $spMetadata  The metadata of the service provider.
	 * @param SimpleSAML_Configuration $idpMetadata  The metadata of the identity provider.
     * @return SAML2_AuthnRequest|SAML2_StorkAuthnRequest
     * @throws Exception
     */
	public static function buildAuthnRequest($extensions, SimpleSAML_Configuration $spMetadata, SimpleSAML_Configuration $idpMetadata) {

		$ar = new SAML2_StorkAuthnRequest();

		if ($spMetadata->hasValue('NameIDPolicy')) {
			$nameIdPolicy = $spMetadata->getString('NameIDPolicy', NULL);
		} else {
			$nameIdPolicy = $spMetadata->getString('NameIDFormat', SAML2_Const::NAMEID_TRANSIENT);
		}

		if ($nameIdPolicy !== NULL) {
			$ar->setNameIdPolicy(array(
				'Format' => $nameIdPolicy,
				'AllowCreate' => TRUE,
			));
		}

		$dst = $idpMetadata->getDefaultEndpoint('SingleSignOnService', array(SAML2_Const::BINDING_HTTP_REDIRECT));
		$dst = $dst['Location'];

		$ar->setIssuer($spMetadata->getString('entityid'));
		$ar->setDestination($dst);

		$ar->setForceAuthn($spMetadata->getBoolean('ForceAuthn', FALSE));
		$ar->setIsPassive($spMetadata->getBoolean('IsPassive', FALSE));

		$protbind = $spMetadata->getValueValidate('ProtocolBinding', array(
				SAML2_Const::BINDING_HTTP_POST,
				SAML2_Const::BINDING_HTTP_ARTIFACT,
				SAML2_Const::BINDING_HTTP_REDIRECT,
			), SAML2_Const::BINDING_HTTP_POST);

		/* Shoaib - setting the appropriate binding based on parameter in sp-metadata defaults to HTTP_POST */
		$ar->setProtocolBinding($protbind);

		if ($spMetadata->hasValue('AuthnContextClassRef')) {
			$accr = $spMetadata->getArrayizeString('AuthnContextClassRef');
			$ar->setRequestedAuthnContext(array('AuthnContextClassRef' => $accr));
		}
    
    if (!empty($extensions)) {
      $ar->setExtensions($extensions);
    }

		self::addRedirectSign($spMetadata, $idpMetadata, $ar);

		return $ar;
	}
	
	
	/**
	 * Build a logout request based on information in the metadata.
	 *
	 * @param SimpleSAML_Configuration $srcMetadata  The metadata of the sender.
	 * @param SimpleSAML_Configuration $dstpMetadata  The metadata of the recipient.
	 */
	public static function buildLogoutRequest(SimpleSAML_Configuration $srcMetadata, SimpleSAML_Configuration $dstMetadata, $destination, $returnTo) {

		$dst = $destination;

		$lr = new SAML2_LogoutRequest();

		$lr->setIssuer($returnTo);
		$lr->setDestination($dst);

		self::addRedirectSign($srcMetadata, $dstMetadata, $lr);

		return $lr;
	}
  
  /**
   * Add signature key and and senders certificate to an element (Message or Assertion).
   *
   * @param SimpleSAML_Configuration $srcMetadata  The metadata of the sender.
   * @param SimpleSAML_Configuration $dstMetadata  The metadata of the recipient.
   * @param SAML2_Message $element  The element we should add the data to.
   */
  public static function addSign(SimpleSAML_Configuration $srcMetadata, SimpleSAML_Configuration $dstMetadata, SAML2_SignedElement $element) {
    $keyArray = SimpleSAML_Utilities::loadPrivateKey($srcMetadata, TRUE);
    $certArray = SimpleSAML_Utilities::loadPublicKey($srcMetadata, FALSE);
    $privateKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA1, array('type' => 'private'));
    if (array_key_exists('password', $keyArray)) {
      $privateKey->passphrase = $keyArray['password'];
    }
    $privateKey->loadKey($keyArray['PEM'], FALSE);

    $element->setSignatureKey($privateKey);

    if ($certArray === NULL) {
      /* We don't have a certificate to add. */
      return;
    }

    if (!array_key_exists('PEM', $certArray)) {
      /* We have a public key with only a fingerprint. */
      return;
    }

    $element->setCertificates(array($certArray['PEM']));
  }


  /**
   * Add signature key and and senders certificate to message.
   *
   * @param SimpleSAML_Configuration $srcMetadata  The metadata of the sender.
   * @param SimpleSAML_Configuration $dstMetadata  The metadata of the recipient.
   * @param SAML2_Message $message  The message we should add the data to.
   */
  private static function addRedirectSign(SimpleSAML_Configuration $srcMetadata, SimpleSAML_Configuration $dstMetadata, SAML2_message $message) {

    if ($message instanceof SAML2_LogoutRequest || $message instanceof SAML2_LogoutResponse) {
      $signingEnabled = $srcMetadata->getBoolean('sign.logout', NULL);
      if ($signingEnabled === NULL) {
        $signingEnabled = $dstMetadata->getBoolean('sign.logout', NULL);
      }
    } elseif ($message instanceof SAML2_AuthnRequest) {
      $signingEnabled = $srcMetadata->getBoolean('sign.authnrequest', NULL);
      if ($signingEnabled === NULL) {
        $signingEnabled = $dstMetadata->getBoolean('sign.authnrequest', NULL);
      }
    }

    if ($signingEnabled === NULL) {
      $signingEnabled = $dstMetadata->getBoolean('redirect.sign', NULL);
      if ($signingEnabled === NULL) {
        $signingEnabled = $srcMetadata->getBoolean('redirect.sign', FALSE);
      }
    }
    if (!$signingEnabled) {
      return;
    }

    self::addSign($srcMetadata, $dstMetadata, $message);
  }


}
