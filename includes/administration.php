<?php
/**
 * Code for custom admin options page
 *
 * @package Opti
 */

/**
 * This function introduces the theme options into the 'Appearance' menu and into a top-level
 * 'Theme Options' menu.
 */
function opti_theme_menu() {

	$page = add_theme_page(
		OPTI_OPTION_TITLE, __( 'Theme Options', 'opti' ), OPTI_EDITTHEME, OPTI_ADMIN_PAGE, 'opti_theme_display'
	);
}
add_action( 'admin_menu', 'opti_theme_menu' );

/**
 *
 */
function opti_admin_enqueue( $hook_suffix ) {

	if ( 'appearance_page_opti_classic_options' != $hook_suffix )
		return;

	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_style( 'opti_admin', OPTI_STYLE_PATH . '/admin.css' );

	wp_enqueue_script( 'farbtastic' );
	wp_enqueue_script( 'opti_admin', OPTI_SCRIPT_PATH . '/admin.js' );

}

add_action( 'admin_enqueue_scripts', 'opti_admin_enqueue' );

/**
 * Renders a simple page to display for the theme menu defined above
 *
 * @param type $active_tab
 * @return type
 */
function opti_theme_display( $active_tab = '' ) {

	$settings = opti_settings_admin();

	// no settings so quit
	if ( count( $settings ) <= 0 ) {
		return;
	}

	echo '<div class="wrap"><div id="icon-themes" class="icon32"></div>';
	echo '<h2>' . __( 'Theme Options', 'opti' ) . '</h2>';

	settings_errors();

	if ( isset( $_GET['tab'] ) ) {
		$active_tab = $_GET['tab'];
	}

	echo '<h2 class="nav-tab-wrapper">';

	foreach ( $settings as $s ) {
		if ( !empty( $s['name'] ) ) {
			$class = array( 'nav-tab' );
			if ( $active_tab == opti_option_name( $s['var'] ) ) {
				$class[] = 'nav-tab-active';
			}
			echo '<a href="' . opti_admin_tab_path( $s['var'] ) . '" class="' . implode( ' ', $class ) . '">' . $s['name'] . '</a>';
		}
	}

	echo '</h2>';

	echo '<form method="post" action="options.php">';

	settings_fields( $active_tab );
	do_settings_sections( OPTI_ADMIN_PAGE );
	submit_button();

	echo '</form></div>';
	echo '<div id="bm-colour-picker"></div>';
}

/**
 *
 * @param type $input
 * @return type
 */
function opti_theme_options_validate( $input ) {

	$settings = opti_settings_admin();
	$return = array( );

	foreach ( $settings as $s ) {
		foreach ( $s['fields'] as $f ) {
			foreach ( $input as $k => $v ) {

				if ( $f['var'] == $k ) {

					// do validation
					switch( $f['type'] ) {

						case 'int':
							$v = (int) $v;
							if ( isset( $f['properties']['range'] ) ) {
								if ( $v < $f['properties']['range'][0] ) {
									$v = $f['properties']['range'][0];
								}
								if ( $v > $f['properties']['range'][1] ) {
									$v = $f['properties']['range'][1];
								}
							}
							break;

						case 'url':
							$v = esc_url_raw( $v );
							break;

						case 'checkbox':
							if ( 'on' === $v ) {
								$v = true;
							} else {
								$v = false;
							}
							break;

						case 'email':
							$v = sanitize_email( $v );
							break;

						case 'text':
						case 'textarea':
							$v = sanitize_text_field( $v );
							break;

						case 'font':
							$v['size'] = (int) $v['size'];
							if ( $v['size'] < -8 ) {
								$v['size'] = -8;
							}
							if ( $v['size'] > 8 ) {
								$v['size'] = 8;
							}
							$v['face'] = sanitize_text_field( $v['face'] );

							break;

						case 'color':
						case 'colour':

							$color = str_replace( '#', '', $v );
							$color = preg_replace( '/[^0-9a-fA-F]/', '', $v );
							if ( strlen( $color ) == 6 || strlen( $color ) == 3 ) {
								$v = '#' . $color;
							} else {
								$v = false;
								if ( !empty( $f['default'] ) ) {
									$v = $f['default'];
								}
							}
							break;
					}

					$return[$k] = $v;
				}
			}
		}
	}

	return $return;
}

/**
 *
 * @param type $name
 * @return type
 */
function opti_admin_tab_path( $name ) {

	return '?page=' . OPTI_ADMIN_PAGE . '&tab=' . opti_option_name( $name );
}

/**
 * Initializes the theme's display options page by registering the Sections,
 * Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */
function opti_initialize_theme_options() {

	global $pagenow;
	$active_tab = '';

	if ( 'themes.php' !== $pagenow && 'options.php' !== $pagenow ) {
		return;
	}

	$settings = opti_settings_admin();

	// no settings so quit
	if ( count( $settings ) <= 0 ) {
		die();
	}

	if ( isset( $_GET['page'] ) && $_GET['page'] == OPTI_ADMIN_PAGE ) {

		if ( isset( $_GET['tab'] ) ) {
			$active_tab = $_GET['tab'];
		} else {
			// tab not set so redirect to the first tab in the list
			foreach ( $settings as $s ) {
				wp_redirect( opti_admin_tab_path( $s['var'] ) );
				break;
			}
		}
	}

	foreach ( $settings as $s ) {

		if ( ! empty( $s['name'] ) ) {
			$option_name = opti_option_name( $s['var'] );
			$section_name = $option_name . '_section';

			// only add settings for the current tab
			if ( $option_name === $active_tab || $pagenow === 'options.php' ) {

				if ( !get_option( $option_name ) ) {
					add_option( $option_name );
				}

				register_setting(
						$option_name, $option_name, 'opti_theme_options_validate'
				);

				add_settings_section(
						$section_name, $s['var'], '__return_false', OPTI_ADMIN_PAGE
				);

				foreach ( $s['fields'] as $f ) {

					$defaults = array(
						'description' => '',
					);

					$f = wp_parse_args( $f, $defaults );

					$fieldname = $option_name . '[' . $f['var'] . ']';
					$properties = array( );
					if ( isset( $f['properties'] ) ) {
						$properties = $f['properties'];
					}

					add_settings_field(
							$fieldname, // ID used to identify the field throughout the theme
							$f['name'], // The label to the left of the option interface element
							'opti_' . $f['type'], // The name of the function responsible for rendering the option interface (the callback)
							OPTI_ADMIN_PAGE, // The page on which this option will be displayed
							$section_name, // The name of the section to which this field belongs
							array( // The array of arguments to pass to the callback
						'name' => $f['name'],
						'description' => $f['description'],
						'field' => $fieldname,
						'value' => opti_option( $f['var'] ),
						'id' => $f['var'],
						'default' => $f['default'],
						'properties' => $properties,
							)
					);
				}
			}
		}
	}
}

add_action( 'admin_init', 'opti_initialize_theme_options' );


/**
 *
 * @param type $args
 */
function opti_text( $args ) {

	echo '<input type="text" class="regular-text" name="' . $args['field'] . '" id="' . $args['id'] . '" value="' . esc_attr( $args['value'] ) . '" />';

	if ( ! empty( $args['description'] ) ) {
		echo '<p class="description">' . $args['description'] . '</p>';
	}

}

/**
 *
 * @param type $args
 */
function opti_email( $args ) {

	opti_text( $args );

}

/**
 *
 * @param type $args
 */
function opti_int( $args ) {
	$extra = '';
	if ( !empty( $args['properties']['range'] ) ) {
		$extra = ' min="' . $args['properties']['range'][0] . '" max="' . $args['properties']['range'][1] . '" ';
	}
	echo '<input type="number" class="small-text" name="' . $args['field'] . '" id="' . $args['id'] . '" value="' . (int) esc_attr( $args['value'] ) . '"' . $extra . ' />';
	if ( !empty( $args['description'] ) ) {
		echo '<p class="description">' . $args['description'] . '</p>';
	}
}

/**
 *
 * @param type $args
 */
function opti_checkbox( $args ) {
	echo '<label for="' . $args['field'] . '"><input type="checkbox" name="' . $args['field'] . '" id="' . $args['id'] . '" ' . checked( $args['value'], true, false ) . ' /> ';
	if ( !empty( $args['description'] ) ) {
		echo $args['description'];
	}
	echo '</label>';
}

/**
 *
 * @param type $args
 */
function opti_textarea( $args ) {
	if ( !empty( $args['description'] ) ) {
		echo '<p>' . $args['description'] . '</p>';
	}
	echo '<textarea class="large-text code" name="' . $args['field'] . '" id="' . $args['id'] . '">' . esc_textarea( $args['value'] ) . '</textarea>';
}

/**
 *
 * @param type $args
 */
function opti_select( $args ) {

	if ( count( $args['properties']['values'] ) ) {

		$size = '';
		$class = 'select_box';
		if ( isset( $args['properties']['size'] ) ) {
			$size = ' size="' . intval( $args['properties']['size'] ) . '"';
			$class = 'select_list';
		}

		echo '<select name="' . $args['field'] . '" id="' . $args['id'] . '" ' . $size . ' class="' . $class . '">';

		foreach ( $args['properties']['values'] as $option ) {

			if ( !isset( $option[1] ) ) {
				$option[1] = $option[0];
			}

			$extra = '';
			if ( $option[0] == $args['value'] ) {
				$extra = ' selected="true"';
			}

			echo '<option value="' . $option[0] . '"' . $extra . '>' . $option[1] . '</option>';
		}

		echo '</select>';
	}
	if ( !empty( $args['description'] ) ) {
		echo '<p class="description">' . $args['description'] . '</p>';
	}
}

/**
 *
 * @param type $args
 */
function opti_multi_checkbox( $args ) {

	if ( !empty( $args['description'] ) ) {
		echo '<p class="description">' . $args['description'] . '</p>';
	}
	if ( count( $args['properties']['values'] ) > 0 ) {

		echo '<a href="" class="multicheck_all">' . __( 'Check All', 'opti' ) . '</a> | ';
		echo '<a href="" class="multicheck_none">' . __( 'Deselect All', 'opti' ) . '</a>';
		echo '<br />';

		foreach ( $args['properties']['values'] as $input ) {

			$checked = '';
			if ( is_array( $args['value'] ) ) {
				if ( in_array( $input[0], $args['value'] ) ) {
					$checked = 'checked="checked"';
				}
			}

			echo '<label class="checkbox-list">';
			echo '<input type="checkbox" name="' . $args['field'] . '[]" value="' . $input[0] . '" ' . $checked . '/> ' . $input[1] . '</label>';
		}
	}
}

/**
 * A wrapper for the colour admin setting
 * created to take into account the crazy American spellings where they missed out a letter!
 *
 * @param type $args
 */
function opti_color( $args ) {
	opti_colour( $args );
}

/**
 *
 * @param type $args
 */
function opti_colour( $args ) {
	echo '<input type="text" class="regular-text colour-input" name="' . $args['field'] . '" id="' . $args['id'] . '" value="' . esc_attr( $args['value'] ) . '" data-default="' . $args['default'] . '" />';
	echo ' <a href="#" class="colour-default">' . __( 'default', 'opti' ) . '</a>';
	if ( !empty( $args['description'] ) ) {
		echo '<p class="description">' . $args['description'] . '</p>';
	}
}