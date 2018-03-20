<?php
/*
 * Plugin Name: Login Cl@ve
 * Description: Consiga que los ciudadanos puedan acceder a sus servicios mediante Cl@ve, un sistema orientado a unificar y simplificar el acceso electrónico de los ciudadanos a los servicios públicos.
 * Version: 1.1
 * Author: Pablo Lara, Mindalatech
 * Author URI: https://www.mindalatech.com/
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *  */
require_once( __DIR__ . '/include/bootstrap.php' );

use ExternalLogin\LoginClave\M4PClaveSettings as M4PClaveSettings;


class LoginClave {

	private $settings = null;

	public function __construct() {

		add_action( 'admin_menu', array( $this, 'external_login_create_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_filter( 'login_form', array( $this, 'external_login' ) );
		add_action( 'init', array( $this, 'login_check' ) );
		add_action( 'wp_logout', array( $this, 'external_login_clave_logout' ) );
		add_action( 'admin_post_externals_login_m4p_save_options', array(
			$this,
			'save_settings'
		) ); //save settings of plugin
		add_action( 'admin_post_externals_login_m4p_export_settings', array( $this, 'export_settings' ) );
		add_action( 'admin_post_externals_login_m4p_import_settings', array( $this, 'import_settings' ) );
		add_shortcode( 'login-clave', array( $this, 'insert_login_access' ) );


	}

	static function m4p_login_clave_url() {
		return wp_login_url() . "?m4p_external_login=clave_login";
	}

	function insert_login_access() {

		global $wp;
		$redirect_to = home_url( $wp->request );

		if ( ! is_user_logged_in() ) {

			$button = "<a href=\"" . self::m4p_login_clave_url() . "\" title='Acceder con cl@ve'>
            <img src=\"" . plugins_url( 'login-clave/assets/images/clave/clave_o_48.jpg' ) . "\"
                 class=\"m4p-clave-img\" alt=\"login Clave\">
        </a>";

		} else {

			$button = "<a style=\"text-decoration: none;\"
                   href=\"" . wp_logout_url( $redirect_to ) . "\" title='Cerrar sesión clave'>
                    <button id=\"clave-butoon\" type=\"button\"
                            style=\"background-color: #fe6603; color: white; width: 100%; margin: 10px 0;\"
                            class=\"button button-secondary button-large\">Cerrar sesión
                    </button>
                </a>

                ";
		}

		return $button;
	}


	/**
	 * Add main menu
	 */
	public function external_login_create_admin_menu() {

		add_menu_page(
			'Login Cl@ve',
			'Login Cl@ve',
			'manage_options',
			'm4p_login_clave_admin_menu',
			array( $this, 'login_clave_create_admin_menu_function' ),
			'dashicons-lock'
		);

		add_submenu_page(
			'm4p_login_clave_admin_menu',
			'Configuración',
			'Configuración',
			'manage_options',
			'm4p_login_clave_configuration',
			array( $this, 'login_clave_configuration_function' )
		);

		add_submenu_page(
			'm4p_login_clave_admin_menu',
			'Importar',
			'Importar',
			'manage_options',
			'm4p_login_clave_import',
			array( $this, 'login_clave_import_function' )
		);

		add_submenu_page(
			'm4p_login_clave_admin_menu',
			'Exportar',
			'Exportar',
			'manage_options',
			'm4p_login_clave_export',
			array( $this, 'login_clave_export_function' )
		);

	}

	public function login_clave_create_admin_menu_function() {
		include( 'templates/backend/admin_external_login.php' );
	}

	public function login_clave_configuration_function() {

		include( 'templates/backend/admin_clave.php' );
	}

	public function login_clave_import_function() {

		include( 'templates/backend/admin_import.php' );

	}

	public function login_clave_export_function() {

		include( 'templates/backend/admin_export.php' );
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {
		register_setting(
			'clave_option_group', // Option group
			'clave_option_name', // Option name
			array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
			'setting_section_id', // ID
			'My Custom Settings', // Title
			array( $this, 'print_section_info' ), // Callback
			'my-setting-admin' // Page
		);

		add_settings_field(
			'id_number', // ID
			'ID Number', // Title
			array( $this, 'id_number_callback' ), // Callback
			'my-setting-admin', // Page
			'setting_section_id' // Section
		);

		add_settings_field(
			'title',
			'Title',
			array( $this, 'title_callback' ),
			'my-setting-admin',
			'setting_section_id'
		);
	}

	public function external_login() {
		if ( ! is_user_logged_in() ) {
			wp_enqueue_style( 'm4p-login-clave-style', plugins_url( 'login-clave/assets/css/clave-admin-style.css' ) );
			include( 'templates/frontend/login_integration.php' );
		}
	}

	public function login_check() {

		$m4p_externals_login_check = new \ExternalLogin\LoginClave\M4PExternalsLoginCheck();

		$m4p_externals_login_check->check();

		$this->check_directories();
	}

	private function check_directories() {

		$settings = $this->get_settings();
		$log_path = $settings->get_log_path();
		if ( empty( $log_path ) ) {
			$upload   = wp_upload_dir();
			$log_path = $upload['basedir'];
		}
		if ( ! file_exists( $log_path ) ) {
			mkdir( $log_path, 0755, true );
		}

	}

	//save the settings of plugin
	function save_settings() {


		if ( isset( $_POST['clave_settings_action'] ) ) {

			$settings = $this->get_settings();

			$settings->load( $_POST );

			$status = $settings->save();

			$err_type = null;

			if ( ! empty( $settings->get_log_path() ) ) {

				$writeable = is_writeable( $settings->get_log_path() );
				if ( false === $writeable ) {
					$status   = false;
				}

			}
			if ( ! empty( $settings->get_cert_directory_path() ) ) {

				$readable = is_readable( $settings->get_cert_directory_path() );
				if ( false === $readable ) {
					$status   = false;
				}

			}

			$status_url = ( true === $status ) ? '1' : '0';

			$active_tab = isset( $_POST['tab'] ) ? $_POST['tab'] : 'general';

			$redirect = "admin.php?page=m4p_login_clave_configuration&tab=$active_tab&status=$status_url";

			wp_redirect( admin_url() . $redirect );


		} else {
			die( 'No script kiddies please!' );
		}
	}

	//Export the settings of plugin
	function export_settings() {
		if ( isset( $_POST['export_settings_action'] ) ) {
			$settings = $this->get_settings();

			$export['filename'] = 'external_login.dat';
			$export['config']   = json_encode( $settings->get_array_option() );


			//Force file download
			header( "Content-Description: File Transfer" );
			header( 'Content-Disposition: attachment; filename="' . $export['filename'] . '"' );
			header( "Content-Type: application/force-download" );
			header( "Content-Transfer-Encoding: binary" );
			header( "Content-Length: " . strlen( $export['config'] ) );

			/* The three lines below basically make the download non-cacheable */
			header( "Cache-control: private" );
			header( "Pragma: private" );
			header( "Expires: Fry, 4 Aug 1989 05:00:00 GMT" );

			echo $export['config'];

		} else {
			die( 'No script kiddies please!' );
		}
	}

	//Export the settings of plugin
	function import_settings() {
		if ( isset( $_POST['import_settings_action'] ) ) {

			$json_settings   = file_get_contents( $_FILES["imported_login_setting"]["tmp_name"] );
			$import_settings = json_decode( $json_settings, true );
			$settings        = new M4PClaveSettings( $import_settings );
			$status_url      = $settings->save();

			wp_redirect( admin_url() . "admin.php?page=m4p_login_clave_import&status=$status_url" );
		} else {
			die( 'No script kiddies please!' );
		}
	}

	/**
	 * Parte de esta función se ha extraído de simplesaml, reemplazando las constantes por la configuración de
	 * WordPress, pero prevalecen algunos fallos de programación
	 *
	 * @throws SimpleSAML_Error_Error
	 */
	public function external_login_clave_logout() {

		$session = SimpleSAML_Session::getInstance();

		if ( isset( $_SESSION['external_login'] ) && 'cl@ve' === $_SESSION['external_login'] ) {

			unset( $_SESSION['external_login'] );

			$authSource = StorkConstants::get_spname();

			$as = new SimpleSAML_Auth_Simple( $authSource );


			$returnTo     = StorkConstants::getLogoutReturnUrl();
			$sendLogoutTo = StorkConstants::get_logout_send_url();


			try {
				$state = array_merge( array(), array(
						'SimpleSAML_Auth_Default.id'       => $authSource,
						'SimpleSAML_Auth_Default.Return'   => $returnTo,
						'SimpleSAML_Auth_Default.ErrorURL' => null,
						'LogoutCallbackState'              => array( 'SimpleSAML_Auth_Default.logoutSource' => $authSource, ),
					)
				);

				/** @var \sspmod_saml_Auth_Source_SP $as */
				$as       = SimpleSAML_Auth_Source::getById( $authSource );
				$metadata = $as->getMetadata();

				$_POST['spcountry'] = 'ES';
				$_POST['country']   = 'ES';

				$idp         = $_POST['spcountry'];
				$idpMetadata = $as->getIdPMetadata( $idp );

				$lr              = stork_saml_Message::buildLogoutRequest( $metadata, $idpMetadata, $sendLogoutTo, $returnTo );
				$nameId['Value'] = StorkConstants::get_spname();
				$lr->setNameId( $nameId );


				$id = SimpleSAML_Auth_State::saveState( $state, 'saml:sp:sso', true );
				$lr->setId( $id );

				$b = new SAML2_StorkHTTPPost( $sendLogoutTo, null );
				$b->sendLogout( $lr );


			} catch ( Exception $exception ) {
				throw new SimpleSAML_Error_Error( 'CREATEREQUEST', $exception );
			}

		}
	}

	/**
	 * @return M4PClaveSettings|null
	 */
	function get_settings() {
		if ( is_null( $this->settings ) ) {
			$this->settings = new M4PClaveSettings();
		}

		return $this->settings;
	}


}

$loginClave = new LoginClave();

