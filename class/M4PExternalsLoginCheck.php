<?php

namespace ExternalLogin\LoginClave;

use M4P\M4PLogin\M4PUser;

if ( ! defined( 'M4P_EXTERNALS_LOGIN_SETTINGS' ) ) {
	define( 'M4P_EXTERNALS_LOGIN_SETTINGS', 'm4p-externals-login-settings' );
}

if ( ! class_exists( 'M4PExternalsLoginCheck' ) ) {

	class M4PExternalsLoginCheck {

		/**
		 * @var null | array
		 */
		private $m4pExternalsLoginSettings = null;

		private $error_message = null;

		//constructor
		function __construct() {

			return $this;
		}

		public function check() {

			if ( isset( $_GET['m4p_external_login'] ) ) {
				if ( isset( $_REQUEST['state'] ) ) {
					parse_str( base64_decode( $_REQUEST['state'] ), $state_vars );

					if ( isset( $state_vars['redirect_to'] ) ) {
						$_GET['redirect_to'] = $_REQUEST['redirect_to'] = $state_vars['redirect_to'];
					}
				}

				$exploder = explode( '_', $_GET['m4p_external_login'] );
				switch ( $exploder[0] ) {
					case 'clave':
						$this->loginClave();
						break;

				}

			}
			if ( isset( $_GET['external_logged'] ) ) {

				if ( $_GET['external_logged'] == 'ok' ) {
					$this->loggedOk();
				}

			}
			if ( isset( $_GET['logout'] ) ) {

				if ( $_GET['logout'] == 'ok' ) {
					if ( isset( $_GET['redirect_to'] ) && strstr( $_GET['redirect_to'], wp_login_url() ) === false ) {
						$redirect = $_GET['redirect_to'];
					} else {
						$redirect = home_url();
					}
					wp_redirect( $redirect );
				}

			}
		}

		private function getExternalsLoginSettings() {
			if ( is_null( $this->m4pExternalsLoginSettings ) ) {
				$this->m4pExternalsLoginSettings = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );
			}
			if ( ! isset( $this->m4pExternalsLoginSettings['role'] ) ) {
				$this->m4pExternalsLoginSettings['role'] = 'subscriber';
			}

			return $this->m4pExternalsLoginSettings;
		}


		/**
		 * Esta función se ha extraído de simplesaml, reemplazando las constantes por la configuración de WordPress,
		 * pero prevalecen algunos fallos de programación
		 *
		 * @throws \SimpleSAML_Error_Exception
		 */
		private function loginClave() {

			// el nombre del metadata del SP
			$authSource = \StorkConstants::get_spname();

			$as = new \SimpleSAML_Auth_Simple( $authSource );

			/** @var \SimpleSAML_Session $session */
			$session = \SimpleSAML_Session::getInstance();

			if ( $session->isValid( $authSource ) ) {
				return;
			}

			$returnTo = \SimpleSAML_Utilities::selfURL();

			$state = array_merge( array(), array(
					'SimpleSAML_Auth_Default.id'       => $authSource,
					'SimpleSAML_Auth_Default.Return'   => $returnTo,
					'SimpleSAML_Auth_Default.ErrorURL' => null,
					'LoginCompletedHandler'            => array( get_class(), 'loginCompleted' ),
					'LogoutCallback'                   => array( get_class(), 'logoutCallback' ),
					'LogoutCallbackState'              => array( 'SimpleSAML_Auth_Default.logoutSource' => $authSource, ),
				)
			);

			/** @var \sspmod_saml_Auth_Source_SP $as */
			$as       = \SimpleSAML_Auth_Source::getById( $authSource );
			$metadata = $as->getMetadata();

			$_POST['spcountry'] = 'ES';
			$_POST['country']   = 'ES';

			$_POST['default'] = true;

			//cargar el metadata del IdP. Para el parámetro ‘country’ se espera que sea puesto por el HTML form
			$idp = $_POST['spcountry'];

			$idpMetadata = $as->getIdPMetadata( $idp );

			try {
				$state['saml:sp:AuthId'] = $authSource;

				//cargar extensiones. Se comprueba si se ha pulsado el botón de "Lanzar Petición" o "Petición a medida"
				$porDefecto = $_POST['default'];

				if ( $porDefecto ) {
					$extensions = \StorkConstants::genDefaultAttrs( $_POST );
				} else {
					$extensions = \StorkConstants::genAttrs( $_POST );
				}

				//generar una Authentication Request
				$ar = \stork_saml_Message::buildAuthnRequest( $extensions, $metadata, $idpMetadata );

				if ( isset( $state['SimpleSAML_Auth_Default.ReturnURL'] ) ) {
					$ar->setRelayState( $state['SimpleSAML_Auth_Default.ReturnURL'] );
				}

				if ( isset( $state['saml:AuthnContextClassRef'] ) ) {
					$accr = \SimpleSAML_Utilities::arrayize( $state['saml:AuthnContextClassRef'] );
					$ar->setRequestedAuthnContext( array( 'AuthnContextClassRef' => $accr ) );
				}

				if ( isset( $state['ForceAuthn'] ) ) {
					$ar->setForceAuthn( (bool) $state['ForceAuthn'] );
				}

				if ( isset( $state['isPassive'] ) ) {
					$ar->setIsPassive( (bool) $state['isPassive'] );
				}

				if ( isset( $state['saml:NameIDPolicy'] ) ) {
					if ( is_string( $state['saml:NameIDPolicy'] ) ) {
						$policy = array(
							'Format'      => (string) $state['saml:NameIDPolicy'],
							'AllowCreate' => true,
						);
					} elseif ( is_array( $state['saml:NameIDPolicy'] ) ) {
						$policy = $state['saml:NameIDPolicy'];
					} else {
						throw new \SimpleSAML_Error_Exception( 'Invalid value of $state[\'saml:NameIDPolicy\'].' );
					}
					$ar->setNameIdPolicy( $policy );
				}

				if ( isset( $state['saml:IDPList'] ) ) {
					$IDPList = $state['saml:IDPList'];
				} else {
					$IDPList = array();
				}

				$ar->setIDPList( array_unique( array_merge( $metadata->getArray( 'IDPList', array() ),
					$idpMetadata->getArray( 'IDPList', array() ),
					(array) $IDPList ) ) );

				if ( isset( $state['saml:ProxyCount'] ) && $state['saml:ProxyCount'] !== null ) {
					$ar->setProxyCount( $state['saml:ProxyCount'] );
				} elseif ( $idpMetadata->getInteger( 'ProxyCount', null ) !== null ) {
					$ar->setProxyCount( $idpMetadata->getInteger( 'ProxyCount', null ) );
				} elseif ( $metadata->getInteger( 'ProxyCount', null ) !== null ) {
					$ar->setProxyCount( $metadata->getInteger( 'ProxyCount', null ) );
				}

				$requesterID = array();
				if ( isset( $state['saml:RequesterID'] ) ) {
					$requesterID = $state['saml:RequesterID'];
				}

				if ( isset( $state['core:SP'] ) ) {
					$requesterID[] = $state['core:SP'];
				}

				$ar->setRequesterID( $requesterID );

				$id = \SimpleSAML_Auth_State::saveState( $state, 'saml:sp:sso', true );
				$ar->setId( $id );

				$b = new \SAML2_StorkHTTPPost( $_POST['country'], $_POST );
				if ( $porDefecto ) {
					$ar->setForceAuthn( false );
					$b->sendDefault( $ar );
				} else {
					$forceAuth = $_POST['forceAuth'] === 'true';
					$ar->setForceAuthn( $forceAuth );
					$b->send( $ar );
				}

			} catch ( \SimpleSAML_Error_Exception $e ) {
				\SimpleSAML_Auth_State::throwException( $state, $e );
			} catch ( \Exception $e ) {
				$e = new \SimpleSAML_Error_UnserializableException( $e );
				\SimpleSAML_Auth_State::throwException( $state, $e );
			}
		}

		/**
		 *
		 * Parte de esta función se ha extraído de simplesaml, reemplazando las constantes por la configuración de
		 * WordPress, pero prevalecen algunos fallos de programación
		 *
		 *
		 * @throws \Exception
		 * @throws \SimpleSAML_Error_Exception
		 */
		private function loggedOk() {

			$b = new \SAML2_HTTPPost();

			/** @var \SAML2_Response $response */
			$response = $b->receive();

			//obtener el metadata
			$authSource = \StorkConstants::get_spname();

			/** @var \sspmod_saml_Auth_Source_SP $as */
			$as       = \SimpleSAML_Auth_Source::getById( $authSource );
			$metadata = $as->getMetadata();

			try {
				//validar la firma
				$retVal = \stork_saml_Message::checkSign( $metadata, $response );
				if ( $retVal ) {
					//obtener las assertions
					$assertions = $response->getAssertions();
					//obtener los atributos
					$attributes = $assertions[0]->getAttributes();
					//obtener el status de la saml response
					$status = $response->getStatus();
					if ( 'urn:oasis:names:tc:SAML:2.0:status:Success' !== $status['Code'] ) {
						// Autenticacion fallida!
						echo '<p>' . $status['Message'] . '</p>';
					} else {
						// Autenticacion correcta!

						// contiene el tipo de login elegido, p.e. AFIRMA | PIN24H
						$loginType = $response->getIssuer();

						$keys = array_keys( $attributes );

						foreach ( $keys as $key ) {
							$keyval = array_search( $key, \StorkConstants::$attrs );
							$keyx   = explode( '.', $keyval );

							switch ( $keyx[0] ) {
								case 'DNI':
									$dniData = explode( '/', $attributes[ $key ]['AttributeValues'] );
									$nif     = end( $dniData );
									break;

								case 'eMail':
									$email = $attributes[ $key ]['AttributeValues'];
									break;

								case 'Nombre':
									$nombre = $attributes[ $key ]['AttributeValues'];
									break;

								case 'Apellidos':
									$apellidos = $attributes[ $key ]['AttributeValues'];
									break;
							}

						}

						$options = $this->getExternalsLoginSettings();

						$options['role'] = apply_filters( 'm4p-clave-new-user-role', $options['role'] );

						$domain = apply_filters( 'm4p-clave-new-user-domain', $options['new_user_domain'] );

						$data = array(
							M4PUser::DATA_USERNAME => $nombre . " " . $apellidos,
							M4PUser::DATA_EMAIL    => $nif . '@' . $domain,
							M4PUser::USER_ROLE     => $options['role'],
							M4PUser::DATA_PASSWORD => $nombre . $nif .'@' . $domain
						);

						$userId = $this->logUser( $data );

						//Guardamos los metas
						if(is_numeric($userId)){
							update_user_meta($userId, 'm4p_clave_nif', $nif);
							update_user_meta($userId, 'm4p_clave_email', $email);
							update_user_meta($userId, 'm4p_clave_type', $loginType);
						}

					}
					$_SESSION['external_login'] = 'cl@ve';

				} else {
					// Validación de firma fallida
					echo '<h2>Ha ocurrido un error';
					echo '<p>La validación de la firma ha fallado.</p>';

				}
			} catch ( \M4P\M4PLogin\M4PLoginException $e ) {

				$this->error_message = $e->getMessage();

				add_filter( 'authenticate',array($this,'logon_error') );

			}

		}


		function logon_error( ) {

			return new \WP_Error('denied',$this->error_message);

		}

		/**
		 * @param $userData
		 *
		 * @return int
		 * @throws \M4P\M4PLogin\M4PLoginException
		 */
		private function logUser( $userData ) {

			$user = new M4PUser();

			return $user->setUserData( $userData )->login();

		}
	}
}