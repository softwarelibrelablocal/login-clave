<?php

namespace ExternalLogin\LoginClave;

if ( ! class_exists( 'M4PClaveSettings' ) ) {


	class M4PClaveSettings {

		//Configuración General
		/** Imdica si se mostrará el botón en el login de wp */
		private $login_button = 'disable';

		/** Rol que tendrán los usuarios */
		private $role = null;

		/** Dominio ficcticio para crear los usuarios  */
		private $new_user_domain = null;

		/** Path donde se almacenan los certificados */
		private $cert_directory_path = null;

		//Configuración IDP
		/** URL login del Intermediador  */
		private $login_send_url = null;

		/** URL login del Intermediador  */
		private $logout_send_url = null;

		/** Nombre del fichero del Certificado del Intermediador de IDPs  */
		private $validate_certificate = null;

		/** Nivel de seguridad qaalavel */
		private $qaaLevel = '3';

		//Configuración SP
		/** Nombre del SP */
		private $spname = null;

		/** Nombre del fichero del Certificado del SP  */
		private $certificate = null;

		/** Nombre del fichero con la clave privada del SP (en formato PEM)  */
		private $privatekey = null;

		/** Password de la clave privada del certificado del SP  */
		private $privatekey_pass = null;

		//Logs
		/** Indica si habilitamos o no los logs */
		private $enable_log;

		/** path donde se almacenará el log */
		private $log_path;

		/** Nivel de exigencia del log */
		private $log_level;

		private $readable_certs = true;

		private $writeable_log = true;

		private $missing_files = array();


		/**
		 * Clave_Settings constructor.
		 *
		 * @param null $data
		 */
		function __construct( $data = null ) {

			$this->load( $data );

			return $this;
		}

		/**
		 * @return string
		 */
		public function get_login_button() {
			return $this->login_button;
		}

		/**
		 * @param string $login_button
		 */
		public function set_login_button( $login_button ) {
			$this->login_button = $login_button;
		}

		/**
		 * @return null
		 */
		public function get_role() {
			return $this->role;
		}

		/**
		 * @param null $role
		 */
		public function set_role( $role ) {
			$this->role = $role;
		}

		/**
		 * @return mixed
		 */
		public function get_new_user_domain() {
			return $this->new_user_domain;
		}

		/**
		 * @param mixed $new_user_domain
		 */
		public function set_new_user_domain( $new_user_domain ) {
			$this->new_user_domain = $new_user_domain;
		}

		/**
		 * @return null
		 */
		public function get_cert_directory_path() {
			return $this->cert_directory_path;
		}

		/**
		 * @param null $cert_directory_path
		 */
		public function set_cert_directory_path( $cert_directory_path ) {
			$this->cert_directory_path = $cert_directory_path;
		}

		/**
		 * @return null
		 */
		public function get_login_send_url() {
			return $this->login_send_url;
		}

		/**
		 * @param null $login_send_url
		 */
		public function set_login_send_url( $login_send_url ) {
			$this->login_send_url = $login_send_url;
		}

		/**
		 * @return null
		 */
		public function get_logout_send_url() {
			return $this->logout_send_url;
		}

		/**
		 * @param null $logout_send_url
		 */
		public function setLogoutSendUrl( $logout_send_url ) {
			$this->logout_send_url = $logout_send_url;
		}

		/**
		 * @return mixed
		 */
		public function get_validate_certificate() {
			return $this->validate_certificate;
		}

		/**
		 * @param mixed $validate_certificate
		 */
		public function set_validate_certificate( $validate_certificate ) {
			$this->validate_certificate = $validate_certificate;
		}

		/**
		 * @return string
		 */
		public function get_qaa_level() {
			return $this->qaaLevel;
		}

		/**
		 * @param string $qaaLevel
		 */
		public function set_qaa_level( $qaaLevel ) {
			$this->qaaLevel = $qaaLevel;
		}

		/**
		 * @return mixed
		 */
		public function get_spname() {
			return $this->spname;
		}

		/**
		 * @param mixed $spname
		 */
		public function set_spname( $spname ) {
			$this->spname = $spname;
		}

		/**
		 * @return mixed
		 */
		public function get_certificate() {
			return $this->certificate;
		}

		/**
		 * @param mixed $certificate
		 */
		public function set_certificate( $certificate ) {
			$this->certificate = $certificate;
		}

		/**
		 * @return mixed
		 */
		public function get_privatekey() {
			return $this->privatekey;
		}

		/**
		 * @param mixed $privatekey
		 */
		public function set_privatekey( $privatekey ) {
			$this->privatekey = $privatekey;
		}

		/**
		 * @return mixed
		 */
		public function get_privatekey_pass() {
			return $this->privatekey_pass;
		}

		/**
		 * @param mixed $privatekey_pass
		 */
		public function set_privatekey_pass( $privatekey_pass ) {
			$this->privatekey_pass = $privatekey_pass;
		}

		/**
		 * @return mixed
		 */
		public function get_enable_log() {
			return $this->enable_log;
		}

		/**
		 * @param mixed $enable_log
		 */
		public function set_enable_log( $enable_log ) {
			$this->enable_log = $enable_log;
		}


		/**
		 * @return mixed
		 */
		public function get_log_path() {
			return $this->log_path;
		}

		/**
		 * @param mixed $log_path
		 */
		public function set_log_path( $log_path ) {
			$this->log_path = $log_path;
		}

		/**
		 * @return mixed
		 */
		public function get_log_level() {
			return $this->log_level;
		}

		/**
		 * @param mixed $log_level
		 */
		public function set_log_level( $log_level ) {
			$this->log_level = $log_level;
		}


		public function is_readable_certs_directory() {
			return $this->readable_certs;
		}

		public function is_writeable_log_directory() {
			return $this->writeable_log;
		}

		public function get_missing_files() {
			return $this->missing_files;
		}


		function show_button() {
			return 'enable' === $this->get_login_button() ? true : false;
		}

		function load( $settings = null ) {
			if ( is_null( $settings ) ) {
				$settings = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );
			}

			if ( isset( $settings['login_button'] ) ) {
				$this->set_login_button( $settings['login_button'] );
			}
			if ( isset( $settings['role'] ) ) {
				$this->set_role( $settings['role'] );
			}
			if ( isset( $settings['new_user_domain'] ) ) {
				$this->set_new_user_domain( $settings['new_user_domain'] );
			}
			if ( isset( $settings['cert_directory_path'] ) ) {
				$this->set_cert_directory_path( $settings['cert_directory_path'] );

				if ( ! empty( $this->get_cert_directory_path() ) ) {

					$readable = is_readable( $this->get_cert_directory_path() );
					if ( false === $readable ) {
						$this->readable_certs = false;
					}
				}
			}

			if ( isset( $settings['login_send_url'] ) ) {
				$this->set_login_send_url( $settings['login_send_url'] );
			}
			if ( isset( $settings['logout_send_url'] ) ) {
				$this->setLogoutSendUrl( $settings['logout_send_url'] );
			}
			if ( isset( $settings['validate_certificate'] ) ) {
				$this->set_validate_certificate( $settings['validate_certificate'] );
			}
			if ( isset( $settings['qaaLevel'] ) ) {
				$this->set_qaa_level( $settings['qaaLevel'] );
			}

			if ( isset( $settings['spname'] ) ) {
				$this->set_spname( $settings['spname'] );
			}

			if ( isset( $settings['certificate'] ) ) {
				$this->set_certificate( $settings['certificate'] );
			}
			if ( isset( $settings['privatekey'] ) ) {
				$this->set_privatekey( $settings['privatekey'] );
			}
			if ( isset( $settings['privatekey_pass'] ) ) {
				$this->set_privatekey_pass( $settings['privatekey_pass'] );
			}

			if ( isset( $settings['enable_log'] ) ) {
				$this->set_enable_log( $settings['enable_log'] );
			}
			if ( isset( $settings['log_path'] ) ) {
				$this->set_log_path( $settings['log_path'] );
				if ( ! empty( $this->get_log_path() ) ) {

					$writeable = is_writeable( $this->get_log_path() );
					if ( false === $writeable ) {
						$this->writeable_log = false;
					}
				}
			}
			if ( isset( $settings['log_level'] ) ) {
				$this->set_log_level( $settings['log_level'] );
			}

			if ( true === $this->is_readable_certs_directory() ) {
				$certificados = array(
					$this->get_certificate(),
					$this->get_privatekey(),
					$this->get_validate_certificate()

				);
				foreach ( $certificados as $certificado ) {
					if ( ! empty( $certificado ) ) {
						$writeable = is_writeable( $this->get_cert_directory_path() . '/' . $certificado );
						if ( false === $writeable ) {
							$this->missing_files[] = $this->get_cert_directory_path() . '/' . $certificado;
						}
					}
				}
			}

			return $this;
		}

		function save() {

			$all_options = get_option( M4P_EXTERNALS_LOGIN_SETTINGS );

			$options = $this->get_array_option();

			$status = update_option( M4P_EXTERNALS_LOGIN_SETTINGS, $options );

			$status = ( true === $status || $all_options === $options ) ? true : false;

			return $status;

		}

		function get_array_option() {
			$options = array(
				'login_button'         => $this->get_login_button(),
				'role'                 => $this->get_role(),
				'new_user_domain'      => $this->get_new_user_domain(),
				'cert_directory_path'  => $this->get_cert_directory_path(),
				'login_send_url'       => $this->get_login_send_url(),
				'logout_send_url'      => $this->get_logout_send_url(),
				'validate_certificate' => $this->get_validate_certificate(),
				'qaaLevel'             => $this->get_qaa_level(),
				'spname'               => $this->get_spname(),
				'certificate'          => $this->get_certificate(),
				'privatekey'           => $this->get_privatekey(),
				'privatekey_pass'      => $this->get_privatekey_pass(),
				'enable_log'           => $this->get_enable_log(),
				'log_path'             => $this->get_log_path(),
				'log_level'            => $this->get_log_level()
			);

			return $options;
		}
	}
}