<div class="wrap">

    <h1 class="wp-heading-inline">Exportar</h1>

    <hr class="wp-header-end">

    <p>
        Cuando hagas clic en el botón de abajo, WordPress creará un archivo para que lo guardes en tu ordenador.
    </p>
    <p>
        Una vez que has guardado el archivo descargado, puedes utilizar la función de importarlo en otra instalación de
        WordPress para importar el contenido de este sitio.
    </p>

    <form method="post" action="<?php echo admin_url() . 'admin-post.php' ?>">
        <input type="hidden" name="action" value="externals_login_m4p_export_settings"/>

        <p class="submit">
			<?php wp_nonce_field( 'm4p_externals_login_nonce_export_settings', 'm4p_externals_login_export_settings_action' ); ?>
            <input type="submit" name="export_settings_action" id="submit" class="button button-primary"
                   value="Descargar archivo de exportación">
        </p>

    </form>
</div>
