<?php

$settings = new \ExternalLogin\LoginClave\M4PClaveSettings();

if ( $settings->show_button() ) {
	$redirect_to = isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';

	$encoded_url = urlencode( $redirect_to );

	?>
    <div class="m4p-clave-container">
        <a href="<?php echo LoginClave::m4p_login_clave_url() ?>" title='<?php
		_e( 'Acceso con', 'm4p-external-login' );
		echo ' ' . 'clave';
		?>'>
            <img src="<?= plugins_url( 'assets/images/clave/clave_o_48.jpg', dirname( __DIR__ ) ) ?>"
                 class="m4p-clave-img" alt="login Clave">
        </a>
    </div>

	<?php

}
