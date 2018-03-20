<?php

namespace M4P\M4PLogin;


class M4PLoginException extends \Exception {

	/**
	 * Error calling service
	 */
	const EMAIL_NOT_DEFINED = 0;

	/**
	 * Error calling service
	 */
	const LOGON_ERROR = 1;


	/**
	 * Error messages
	 * @access protected
	 * @var array
	 */
	protected $messages = [
		self::EMAIL_NOT_DEFINED => 'Email is not defined %s: %s',
		self::LOGON_ERROR => 'Logon error %s: %s'

	];

	/**
	 * EncryptionException constructor.
	 * Receives an error code and selects the right message. Both code and message
	 * has to be set in descendant classes, usually filling the protected $messages
	 * member.
	 * @access public
	 *
	 * @param int $code Message code
	 * @param string $message Message to show
	 * @param string $className Class Name or identification string for the exception
	 * @param \Exception|null $previous
	 */
	public function __construct( $code, $message = '', $className = '', \Exception $previous = null ) {
		// Format class name
		if ( ! empty( $className ) ) {
			$className = " ($className)";
		}
		$codes = array_keys( $this->messages );
		if ( ! in_array( $code, $codes ) ) {
			$msg = 'Invalid exception code';
		} else {
			$msg = $this->messages[ $code ];
			$msg = sprintf( $msg, $className, $message );
		}
		parent::__construct( $msg, $code, $previous );
	}

	/**
	 * Allow add new messages to inherited classes. Must be called before parent constructor.
	 * @access protected
	 *
	 * @param $msgArray
	 */
	protected function addMessages( $msgArray ) {
		$this->messages = $this->messages + $msgArray;
	}
}