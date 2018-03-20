<?php


namespace M4P\M4PLogin;

use M4P\M4PLogin\M4PLoginException;

if ( ! class_exists( 'M4PUser' ) ) {

	class M4PUser {


		const DATA_USERNAME = 'username';

		const DATA_EMAIL = 'email';

		const DATA_PASSWORD = 'password';

		const USER_ROLE = 'role';

		protected $username = '';

		protected $email = '';

		protected $pwd = '';

		protected $role = '';

		public function __construct( array $userData = null ) {


			if ( ! is_null( $userData ) ) {
				$this->setUserData( $userData );
			}


		}

		/**
		 * @return string
		 */
		public function getUsername() {
			return $this->username;
		}

		/**
		 * @param string $username
		 */
		public function setUsername( $username ) {
			$this->username = $username;
		}

		/**
		 * @return string
		 */
		public function getEmail() {
			return $this->email;
		}

		/**
		 * @param string $email
		 */
		public function setEmail( $email ) {
			$this->email = $email;
		}

		/**
		 * @return string
		 */
		public function getPwd() {
			return $this->pwd;
		}

		/**
		 * @param string $pwd
		 */
		public function setPwd( $pwd ) {
			$this->pwd = $pwd;
		}

		/**
		 * @return string
		 */
		public function getRole() {
			return $this->role;
		}

		/**
		 * @param string $role
		 */
		public function setRole( $role ) {
			/*
			 * todo: documentar filtro
			 */
			$role = apply_filters( 'm4p-user-role', $role );

			$this->role = $role;
		}

		public function setUserData( array $userData ) {
			$this->setUsername( $userData[ self::DATA_USERNAME ] );
			$this->setEmail( $userData[ self::DATA_EMAIL ] );
			$this->setPwd( $userData[ self::DATA_PASSWORD ] );
			$role = ( isset( $userData[ self::USER_ROLE ] ) ) ? $userData[ self::USER_ROLE ] : null;
			$this->setRole( $role );

			return $this;
		}

		/**
		 * Return true if user exists, false in other case
		 *
		 * @return false|int
		 * @throws \M4P\M4PLogin\M4PLoginException
		 */
		public function userExists() {
			if ( ! empty( $this->email ) ) {
				return email_exists( $this->email );
			} else {
				throw new M4PLoginException(
					M4PLoginException::EMAIL_NOT_DEFINED
				);
			}
		}

		/**
		 * @return int
		 * @throws \M4P\M4PLogin\M4PLoginException
		 */
		protected function findOrCreateWordPressUser() {

			if ( $this->userExists() === false ) {
				wp_create_user( $this->username, $this->pwd, $this->email );
				$user = get_user_by( 'email', $this->email );
				if ( ! is_null( $this->role ) ) {
					$user->set_role( $this->role );
				}
				update_user_meta( $user->ID, 'm4p_email_login', $this->email );
			} else {
				$user = get_user_by( 'email', $this->email );
			}

			return $user->ID;
		}

		/**
		 * @param bool $remember
		 *
		 * @throws \M4P\M4PLogin\M4PLoginException
		 */
		protected function logon( $remember = true ) {
			$creds = array(
				'user_login'    => $this->email,
				'user_password' => $this->pwd,
				'remember'      => $remember
			);

			$user = wp_signon( $creds, false );

			if ( is_wp_error( $user ) ) {

				$mensaje = ( $user->get_error_message() );

				throw new \M4P\M4PLogin\M4PLoginException( M4PLoginException::LOGON_ERROR, $mensaje );


			} else {
				wp_clear_auth_cookie();
				wp_set_current_user( $user->ID );
				wp_set_auth_cookie( $user->ID );
				if ( isset( $_GET['redirect_to'] ) && strstr( $_GET['redirect_to'], wp_login_url() ) === false ) {
					$redirect = $_GET['redirect_to'];
				} else {
					$redirect = home_url();
				}
				wp_redirect( $redirect );
			}
		}

		/**
		 * @param array|null $userData
		 *
		 * @return int
		 * @throws \M4P\M4PLogin\M4PLoginException
		 *
		 */
		public function login( array $userData = null ) {


			if ( ! is_null( $userData ) ) {
				$this->setUserData( $userData );
			}

			$userId = $this->findOrCreateWordPressUser();

			if ( is_numeric( $userId ) ) {
				$this->logon();
			}

			return $userId;

		}

	}
}
