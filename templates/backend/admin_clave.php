<?php

$settings = new \ExternalLogin\LoginClave\M4PClaveSettings();

$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general';
$isEnviable = true;
?>
<div class="wrap">
    <h1 class="wp-heading-inline">Configuración login Cl@ve</h1>
	<?php
	if ( isset( $_GET['status'] ) ) {
		switch ( $_GET['status'] ) {
			case '1':
				?>
                <div class="notice notice-success is-dismissible">
                    <p><strong>Configuración guardada.</strong></p>
                </div>
				<?php
				break;
			case '0':

				break;
			default:
				break;
		}
	}
	$mensaje = '';

	if ( false === $settings->is_readable_certs_directory() ) {
		$mensaje = 'El directorio de certificados <code>' . $settings->get_cert_directory_path() . '</code> no es accesible, modifique los permisos o indique otro.';
	}
	if ( false === $settings->is_writeable_log_directory() ) {
		$mensaje = 'El directorio de logs <code>' . $settings->get_log_path() . '</code> no es accesible, modifique los permisos o indique otro.';

	}

	if ( ! empty( $mensaje ) ) {
		?>
        <div class="notice notice-error is-dismissible">
            <p><strong>ERROR:</strong> <?= $mensaje ?></p>
        </div>
		<?php
	}

	$path_certificados = $settings->get_missing_files();
	if ( true === is_array( $path_certificados ) && 0 < count( $path_certificados ) ) {
		foreach ( $path_certificados as $path_certificado ) {
			$mensaje = 'El certificado <code>' . $path_certificado . '</code> no existe o no es accesible.';
			?>
            <div class="notice notice-error is-dismissible">
                <p><strong>ERROR:</strong> <?= $mensaje ?></p>
            </div>
			<?php
		}
	}

	?>
    <h2 class="nav-tab-wrapper">

        <a href="?page=m4p_login_clave_configuration&tab=general"
           class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>">General</a>

        <a href="?page=m4p_login_clave_configuration&tab=proveedor"
           class="nav-tab <?php echo $active_tab == 'proveedor' ? 'nav-tab-active' : ''; ?>">Proveedor De Identidad
            (IDP)</a>

        <a href="?page=m4p_login_clave_configuration&tab=identificacion"
           class="nav-tab <?php echo $active_tab == 'identificacion' ? 'nav-tab-active' : ''; ?>">Proveedor de Servicio
            (SP)</a>

        <a href="?page=m4p_login_clave_configuration&tab=log"
           class="nav-tab <?php echo $active_tab == 'log' ? 'nav-tab-active' : ''; ?>">Log</a>

        <a href="?page=m4p_login_clave_configuration&tab=ayuda"
           class="nav-tab <?php echo $active_tab == 'ayuda' ? 'nav-tab-active' : ''; ?>">Ayuda</a>
    </h2>

    <hr class="wp-header-end">

    <form method="post" action="<?php echo admin_url() . 'admin-post.php' ?>">
        <input type="hidden" name="action" value="externals_login_m4p_save_options"/>
        <input type="hidden" name="tab" value="<?= $active_tab ?>"/>
        <table class="form-table">
            <tbody>

			<?php
			switch ( $active_tab ) {


				case 'proveedor':
					?>
                    <tr>
                        <th><label for="login_send_url">URL login del Intermediador:</label></th>
                        <td><input type="text" id="login_send_url" name="login_send_url" class="regular-text code"
                                   required="required"
                                   placeholder="https://se-pasarela.clave.gob.es/Proxy/ServiceProvider"
                                   value="<?php echo $settings->get_login_send_url() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="logout_send_url">URL logout del Intermediador:</label></th>
                        <td><input type="text" id="logout_send_url" name="logout_send_url" class="regular-text code"
                                   required="required"
                                   placeholder="https://se-pasarela.clave.gob.es/Proxy/LogoutAction"
                                   value="<?php echo $settings->get_logout_send_url() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="validate_certificate">Nombre del fichero del Certificado del Intermediador de
                                IDPs:</label></th>
                        <td><input type="text" id="validate_certificate" name="validate_certificate"
                                   class="regular-text code"
                                   required="required"
                                   placeholder="certificadoProxy.crt"
                                   value="<?php echo $settings->get_validate_certificate() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="qaaLevel">Nivel de seguridad:</label></th>
                        <td>
                            <select id="qaaLevel" name="qaaLevel">
								<?php

								$qaaLevel = $settings->get_qaa_level();

								?>

                                <option value="1" <?= $qaaLevel === '1' ? 'selected="selected"' : '' ?>>
                                    1
                                </option>
                                <option value="2" <?= $qaaLevel === '2' ? 'selected="selected"' : '' ?>>
                                    2
                                </option>
                                <option value="3" <?= $qaaLevel === '3' ? 'selected="selected"' : '' ?>>
                                    3
                                </option>
                            </select>
                        </td>
                    </tr>
					<?php
					break;
				case 'identificacion':
					?>
                    <tr>
                        <th><label for="spname">Nombre del SP:</label></th>
                        <td><input type="text" id="spname" name="spname" class="regular-text code"
                                   required="required"
                                   placeholder="demo-sp-php"
                                   value="<?php echo $settings->get_spname() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="certificate">Nombre del fichero del Certificado del SP:</label></th>
                        <td><input type="text" id="certificate" name="certificate" class="regular-text code"
                                   required="required"
                                   placeholder="Stork.crt"
                                   value="<?php echo $settings->get_certificate() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="privatekey">Nombre del fichero con la clave privada del SP (en formato
                                PEM):</label></th>
                        <td><input type="text" id="privatekey" name="privatekey" class="regular-text code"
                                   required="required"
                                   placeholder="Stork.key"
                                   value="<?php echo $settings->get_privatekey() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="privatekey_pass">Password de la clave privada del certificado del SP:</label>
                        </th>
                        <td><input type="password" id="privatekey_pass" name="privatekey_pass" class="regular-text code"
                                   required="required"
                                   placeholder="admin"
                                   value="<?php echo $settings->get_privatekey_pass() ?>">
                        </td>
                    </tr>

					<?php
					break;
				case 'log':
					$upload = wp_upload_dir();
					?>

                    <tr>
                        <th><label for="log_path">Path del log:</label></th>
                        <td><input type="text" id="log_path" name="log_path"
                                   class="regular-text code"
                                   required="required"
                                   placeholder="<?php echo $upload['basedir'] ?>"
                                   value="<?php echo $settings->get_log_path() ?>">
                        </td>
                    </tr>

                    <tr>
                        <th><label for="enable_log">Guardar llamadas al servício:</label></th>
                        <td>
                            <select id="enable_log" name="enable_log">
								<?php

								$loginButton = $settings->get_enable_log();

								?>

                                <option value="enable" <?= $loginButton === 'enable' ? 'selected="selected"' : '' ?>>
                                    Habilitado
                                </option>
                                <option value="disable" <?= $loginButton === 'disable' ? 'selected="selected"' : '' ?>>
                                    Deshabilitado
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="log_level">Nivel de error en las llamadas:</label></th>
                        <td>
                            <select id="log_level" name="log_level">
								<?php
								$levels = array(
									LOG_ERR     => 'LOG_ERR',
									LOG_WARNING => 'LOG_WARNING',
									LOG_NOTICE  => 'LOG_NOTICE',
									LOG_INFO    => 'LOG_INFO',
									LOG_DEBUG   => 'LOG_DEBUG'
								);

								$logLevel = (int) $settings->get_log_level();
								foreach ( $levels as $level => $displayLevel ) {
									$selected = $level === $logLevel ? 'selected="selected"' : '';
									?>
                                    <option value="<?= $level ?>" <?= $selected ?>><?= $displayLevel ?></option>
									<?php
								}
								?>
                            </select>
                        </td>
                    </tr>


					<?php
					break;
				case 'ayuda':
					$isEnviable = false;
					break;
				case 'general':
				default:
					$roles = get_editable_roles();
					$userRole = $settings->get_role();
					$loginButtonChecked = 'checked';

					?>

                    <tr>
                        <th><label for="login_button">Mostrar el botón de cl@ve en el loguin de WP:</label></th>
                        <td>
                            <select id="login_button" name="login_button">
								<?php

								$loginButton = $settings->get_login_button();

								?>

                                <option value="enable" <?= $loginButton === 'enable' ? 'selected="selected"' : '' ?>>
                                    Mostrar
                                </option>
                                <option value="disable" <?= $loginButton === 'disable' ? 'selected="selected"' : '' ?>>
                                    Ocultar
                                </option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th><label for="role">Perfil:</label></th>
                        <td>
                            <select id="role" name="role">
								<?php
								foreach ( $roles as $rolSlug => $rolData ) {
									$selected = $userRole === $rolSlug ? 'selected="selected"' : '';
									?>
                                    <option value="<?= $rolSlug ?>" <?= $selected ?>><?= $rolData['name'] ?></option>
									<?php
								}
								?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="new_user_domain">Dominio emails clave:</label></th>
                        <td><input type="text" id="new_user_domain" name="new_user_domain"
                                   class="regular-text code"
                                   required="required"
                                   placeholder="loginclave.test"
                                   value="<?php echo $settings->get_new_user_domain() ?>">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="cert_directory_path">Path de los certificados:</label></th>
                        <td><input type="text" id="cert_directory_path" name="cert_directory_path"
                                   class="regular-text code"
                                   required="required"
                                   placeholder="/var/simplesamlphp/cert/"
                                   value="<?php echo $settings->get_cert_directory_path() ?>">
                        </td>
                    </tr>
					<?php
					break;
			}
			?>

            </tbody>
        </table>
		<?php
		if ( $active_tab === 'ayuda' ) {
			?>
            <p>
                <strong>Cl@ve Identificación</strong> es un sistema orientado a unificar y simplificar el acceso
                electrónico de los ciudadanos a los
                servicios públicos, permitiendo que estos puedan identificarse ante la Administración mediante claves
                concertadas (usuario más contraseña), sin tener que recordar claves diferentes para acceder a los
                distintos servicios.
            </p>
            <p>
                Cl@ve complementa los actuales sistemas de acceso mediante DNI-e y certificado electrónico, y está
                diseñado para ofrecer en un futuro la posibilidad de realizar firma en la nube, con certificados
                personales custodiados en servidores remotos.


            </p>
            <br>
            <h3>Shortcodes</h3>
            <hr>
            <table class="form-table">
                <tbody>

                <tr>
                    <th>[login-clave]</th>
                    <td> Añade un boton de acceso mediante Cl@ve</td>
                </tr>

                </tbody>
            </table>

            <br>
            <h3>Filtros</h3>

            <hr>

            <table class="form-table">
                <tbody>

                <tr>
                    <th>m4p-clave-new-user-role</th>
                    <td>Permite modificar el rol que se le asigna a los nuevos usuarios</td>
                </tr>
                <tr>
                    <th>m4p-clave-new-user-domain</th>
                    <td>Permite modificar el dominio ficticio con el que se crean los emails de los nuevos usuarios</td>
                </tr>

                </tbody>
            </table>

            <br>
            <h3>Documentación de cl@ve Identificación</h3>
            <hr>
            <ul>
                <li><a href="https://administracionelectronica.gob.es/ctt/clave" target="_blank">Portal de
                        administración
                        electrónica</a></li>
                <li><a href="http://clave.gob.es/" target="_blank">Portal informativo sobre el uso de CL@VE</a></li>
            </ul>


			<?php
		} else {
			?>
            <p class="submit">
				<?php wp_nonce_field( 'm4p_externals_login_nonce_save_settings', 'm4p_externals_login_settings_action' ); ?>
                <input type="submit" name="clave_settings_action" id="submit" class="button button-primary"
                       value="Guardar cambios">
            </p>

			<?php
		}
		?>

    </form>
</div>

