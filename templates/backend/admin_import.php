<?php
$bytes = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
$size  = size_format( $bytes );
?>

<div class="wrap">

    <h1 class="wp-heading-inline">Importar</h1>
	<?php
	if ( isset( $_GET['status'] ) ) {
		switch ( $_GET['status'] ) {
			case '1':
				$url_certificados = "admin.php?page=m4p_login_clave_configuration&tab=general&status=0";
				$url_logs = "admin.php?page=m4p_login_clave_configuration&tab=log&status=0";
				?>
                <div class="notice notice-success is-dismissible">
                    <p><strong>Completado: </strong>Configuración importada correctamente.</p>
                </div>
                <div class="notice notice-warning is-dismissible">
                    <p><strong>Aviso: </strong>Es posible que el <a href="<?= $url_certificados ?>" target="_blank">path
                            de los certificados</a> o el <a href="<?= $url_logs ?>" target="_blank">path de logs</a> no
                        se correspondan con los de su servidor, revise la configuración</p>
                </div>
				<?php
				break;
			default:
				break;
		}
	}
	?>
    <hr class="wp-header-end">

    <p>
        ¡Hola! Sube tu archivo e importaremos toda la configuración, login con cl@ve, proveedor del servicio e
        identificación en este sitio.

    </p>
    <p>
        Elige un archivo (.dat) para subir, luego haz clic en "Subir archivo" para importarlo.
    </p>
    <form method="post" action="<?php echo admin_url() . 'admin-post.php' ?>" enctype="multipart/form-data">
        <input type="hidden" name="action" value="externals_login_m4p_import_settings"/>


        Elige un archivo de tu ordenador: (Tamaño máximo: <?php echo $size; ?>)
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $bytes; ?>">
        <input type="file" name="imported_login_setting" id="import_file" required="required">

        <p class="submit">
			<?php wp_nonce_field( 'm4p_externals_login_nonce_import_settings', 'm4p_externals_login_import_settings_action' ); ?>
            <input type="submit" name="import_settings_action" id="submit" class="button button-primary"
                   value="Subir archivo e importar">
        </p>
    </form>
</div>
