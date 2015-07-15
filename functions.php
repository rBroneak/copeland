<?php
/**
 * Theme modification functions
 *
 * @package Opti
 */

define( 'OPTI_BLOGPATH', get_template_directory_uri() );
define( 'OPTI_STYLE_PATH', OPTI_BLOGPATH . '/css' );
define( 'OPTI_SCRIPT_PATH', OPTI_BLOGPATH . '/js' );
define( 'OPTI_EDITTHEME', 'edit_theme_options' );
define( 'OPTI_ADMIN_PAGE', 'opti_classic_options' );
define( 'OPTI_OPTION_PREFIX', 'opti' );
define( 'OPTI_OPTION_TITLE', __( 'Opti Options', 'opti' ) );

if ( is_admin() ) {
	include( 'includes/administration.php' );
}

include( 'includes/csscolor.php' );

/**
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/includes/jetpack.php' );

/**
 *
 * @return array
 */
function opti_settings_admin() {

	$opti_cats = array( );

	// only load this stuff in the admin pages
	if ( is_admin() ) {
		$opti_categories = get_categories( 'hide_empty=1' );
		foreach ( $opti_categories as $b ) {
			$opti_cats[$b->term_id] = array( $b->term_id, $b->cat_name );
		}
	}

	$sections = array(
		'homepage' => array(
			'name' => __( 'Homepage', 'opti' ),
			'description' => '',
			'var' => 'homepage',
			'fields' => array(
				'hide-homepage-categories' => array(
					'name' => __( 'Display Homepage Categories', 'opti' ),
					'var' => 'hide-homepage-categories',
					'type' => 'checkbox',
					'default' => '',
					'description' => __( 'Hide the homepage categories listing', 'opti' ),
				),
				'homepage-categories' => array(
					'name' => __( 'Homepage Categories', 'opti' ),
					'var' => 'homepage-categories',
					'type' => 'multi_checkbox',
					'properties' => array(
						'values' => $opti_cats,
					),
					'default' => array( ),
					'description' => __( 'Categories to display on the left hand side of the homepage. Deselect all of them to automatically select posts from the categories with the most content.', 'opti' ),
				),
				'display-header-image' => array(
					'name' => __( 'Display Header Image on', 'opti' ),
					'var' => 'display-header-image',
					'type' => 'select',
					'properties' => array(
						'values' => array(
							array( 'homepage', __( 'Homepage', 'opti' ) ),
							array( 'all-pages', __( 'All Pages', 'opti' ) ),
						)
					),
					'default' => 'homepage',
					'description' => __( 'Note: You need to upload and select an image for this to take effect.', 'opti' ),
				),
				'featured-posts' => array(
					'name' => __( 'Featured Posts', 'opti' ),
					'var' => 'featured-posts',
					'type' => 'int',
					'properties' => array(
						'range' => array( 1, 30 )
					),
					'default' => 2,
					'description' => __( 'Number of featured posts to display on the homepage in the featured categories section.', 'opti' ),
				),
				'display-related-posts' => array(
					'name' => __( 'Display Related Posts', 'opti' ),
					'var' => 'display-related-posts',
					'type' => 'checkbox',
					'default' => '',
					'description' => __( 'Would you like to display the related posts on single post pages?', 'opti' ),
				),
			),
		),
	);

	return $sections;
}


/**
 *
 */
function opti_head_styles() {

	$styles = apply_filters( 'opti_styles', array() );

	if ( !empty( $styles ) ) {
		echo '<style>';
		echo implode( "\n", $styles );
		echo '</style>';
	}

}


/**
 *
 * @return array
 */
function opti_colour_styles( $styles ) {

	$header_colour = new CSS_Color( get_option( 'content_bg_color', '#293033' ) );
	$header_colour_link = new CSS_Color( get_option( 'content_bg_color', '#293033' ), get_option( 'content_link_color', '#1899CB' ) );
	$link_colour = new CSS_Color( '#ffffff', get_option( 'content_link_color', '#1899CB' ) );

	$new_styles = array();

	$new_styles = array(
		'#masthead { background:#' . $header_colour->bg['0'] . '; }',
		'#masthead #logo a { color:#' . $header_colour->fg['0'] . '; }',
		'#masthead h2 { color:#' . $header_colour->fg['+2'] . '; }',
		'#nav-primary { background:#' . opti_css_gradient( $header_colour->bg['-2'], $header_colour->bg['-3'] ) . '; border-color:#' . $header_colour->bg['-3'] . ' }',
		'#nav-primary li:hover, #nav-primary li.current-cat { background-color: #' . $header_colour->bg['-3'] . '; }',
		'#nav-primary li { border-right-color:#' . $header_colour->bg['-3'] . '; border-left-color:#' . $header_colour->bg['-1'] . '; }',
		'#nav-primary .current-menu-item { background-color:#' . $header_colour->bg['-3'] . '; color:#' . $header_colour->fg['-3'] . '; }',
		'#nav-primary .current-menu-item > a, #nav-primary .current-cat > a { border-color:#' . $header_colour_link->fg['0'] . '; color:#' . $header_colour->fg['-3'] . '; }',
		'#masthead input.searchfield { background:#' . $header_colour->bg['-1'] . '; color:#' . $header_colour->fg['-1'] . '; }',
		'#masthead input.searchfield::-webkit-input-placeholder { color:#' . $header_colour->fg['-1'] . '; }',
		'#masthead input.searchfield::-moz-placeholder { color:#' . $header_colour->fg['-1'] . '; }',
		'#masthead input.searchfield:-moz-placeholder { color:#' . $header_colour->fg['-1'] . '; }',
		'#masthead input.searchfield:-ms-placeholder { color:#' . $header_colour->fg['-1'] . '; }',
		'#masthead input.searchfield:focus, #masthead input.searchfield:hover { background:#' . $header_colour->bg['-2'] . '; color:#' . $header_colour->fg['-2'] . '; }',
		'#masthead input.searchfield::-webkit-input-placeholder, #masthead input.searchfield::-moz-placeholder { color:#' . $header_colour->fg['-3'] . '; }',
		'a, a:visited { color:#' . $link_colour->fg['0'] . '; }',
		'footer { color:#' . $header_colour->fg['-3'] . '; background:#' . $header_colour->bg['-3'] . '; }',
		'footer a, footer a:visited { color:#' . $header_colour_link->fg['-3'] . '; }',
		'#footer-wrap { border-color:#' . $header_colour->bg['-4'] . '; }',
		'#featured-cats h5 { background:#' . $header_colour->bg['+5'] . '; border-color:#' . $header_colour->bg['+3'] . '; }',
		'#featured-cats h5 a, #featured-cats h5 a:visited { color:#' . $header_colour->fg['+5'] . '; }',
	);

	// hide header and search form if header text is hidden
	if ( ! get_bloginfo( 'description' ) && ! get_bloginfo( 'name' ) ) {
		$new_styles[] = '#branding { display:none; }';
		$new_styles[] = '#masthead form.searchform { display:none; }';
	}

	return array_merge( $styles, $new_styles );
}

/**
 *
 * @param type $wp_customize
 */
function opti_customize_register( $wp_customize ) {

	$colors = array( );
	$colors[] = array( 'slug' => 'content_bg_color', 'default' => '#293033', 'label' => __( 'Content Background Color', 'opti' ) );
	$colors[] = array( 'slug' => 'content_link_color', 'default' => '#1899CB', 'label' => __( 'Content Link Color', 'opti' ) );

	foreach ( $colors as $color ) {
		$wp_customize->add_setting( $color['slug'], array(
			'default' => $color['default'],
			'type' => 'option',
			'capability' => OPTI_EDITTHEME,
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array(
			'label' => $color['label'],
			'section' => 'colors',
			'settings' => $color['slug']
		) ) );
	}

	$wp_customize->add_setting('opti_content_header_position', array(
		'default'        => 'below_nav',
		'capability'     => 'edit_theme_options',
		'type'           => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control( 'header_position_select', array(
		'settings' => 'opti_content_header_position',
		'label'   => __('Header Position:', 'opti'),
		'section' => 'header_image',
		'type' => 'select',
		'choices' => array(
			'below_nav' => __('Below Navigation (default)', 'opti'),
			'header' => __('In Header', 'opti'),
		),
	));
}


/**
 *
 * @param type $from
 * @param type $to
 */
function opti_css_gradient( $from, $to ) {

	$style = '';
	$style .= 'background: #' . $to . ';';
	$style .= 'background: -moz-linear-gradient(top,  #' . $from . ' 0%, #' . $to . ' 100%);';
	$style .= 'background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#' . $from . '), color-stop(100%,#' . $to . '));';
	$style .= 'background: -webkit-linear-gradient(top, #' . $from . ' 0%, #' . $to . ' 100%);';
	$style .= 'background: -o-linear-gradient(top, #' . $from . ' 0%,#' . $to . ' 100%);';
	$style .= 'background: -ms-linear-gradient(top, #' . $from . ' 0%,#' . $to . ' 100%);';
	$style .= 'background: linear-gradient(to bottom, #' . $from . ' 0%,#' . $to . ' 100%);';
	return $style;

}


/**
 * Even/Odd Classes
 *
 * @global type $current_class
 * @param array $classes
 * @return type
 */
function opti_oddeven_post_class( $classes ) {

	global $current_class;
	$classes[] = $current_class;
	$current_class = ( 'odd' == $current_class ) ? 'even' : 'odd';
	return $classes;

}


global $current_class;
$current_class = 'odd';


/**
 *
 */
function opti_scripts_init() {

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'masonry' );

	if ( opti_has_featured_posts() ) {
		wp_enqueue_script( 'opti-script-slider', get_template_directory_uri() . '/js/slider.js', array(), '1.2' );
	}
	wp_enqueue_script( 'opti-elemental-components', get_template_directory_uri() . '/js/jquery.elemental.components.js' );
	wp_enqueue_script( 'hoverintent' );
	wp_enqueue_script( 'opti-script-responsive-navigation', get_template_directory_uri() . '/js/responsiveNavigation.js' );
	wp_enqueue_script( 'opti-script-main', get_template_directory_uri() . '/js/main.js' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}


/**
 * include custom stylesheets
 */
function opti_styles_init() {

	/* Translators: If there are characters in your language that are not
	 * supported by Merriweather, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$merriweather = _x( 'on', 'Merriweather font: on or off', 'opti' );

	if ( 'off' !== $merriweather ) {
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'opti-font-merriweather', $protocol . '://fonts.googleapis.com/css?family=Merriweather', null, '1.0', 'all' );
	}

	wp_enqueue_style( 'opti-style', get_stylesheet_directory_uri() . '/style.css', null, '1.0', 'all' );
	wp_enqueue_style( 'opti-style-1140', get_template_directory_uri() . '/css/1140.css', null, '1.0', 'all' );
	wp_enqueue_style( 'opti-style-ie', get_template_directory_uri() . '/css/ie.css', null, '1.0', 'all' );
	wp_enqueue_style( 'opti-style-print', get_template_directory_uri() . '/css/print.css', null, '1.0', 'print' );

}


/**
 * Load stuff (custom theme support stuff)
 */
function opti_after_setup_theme() {

	load_theme_textdomain( 'opti', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'opti-featured', 345, 210, true );
	add_image_size( 'opti-post-loop', 105, 85, true );
	add_image_size( 'opti-archive', 120, 120, true );

	add_theme_support( 'custom-background' );

	$args = array(
		'random-default' => false,
		'width' => apply_filters( 'opti_header_width', 1100 ),
		'height' => apply_filters( 'opti_header_height', 150 ),
		'default-image' => '',
		'flex-height' => true,
		'header-text' => false,
		'uploads' => true,
		'wp-head-callback' => '',
		'admin-head-callback' => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $args );

	register_nav_menus(
		array(
			'navigation_top' => __( 'Main Navigation', 'opti' ),
			'navigation_bottom' => __( 'Sub Navigation', 'opti' )
		)
	);

}

add_action( 'after_setup_theme', 'opti_after_setup_theme' );



/**
 * Initialize Sidebars
 */
function opti_widgets_init() {

	register_sidebar(
		array(
			'name' => __( 'Sidebar Widgets', 'opti' ),
			'id' => 'sidebar-1',
			'description' => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name' => __( 'Left Footer Widgets', 'opti' ),
			'id' => 'sidebar-2',
			'description' => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => __( 'Left Middle Footer Widgets', 'opti' ),
			'id' => 'sidebar-3',
			'description' => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => __( 'Right Middle Footer Widgets', 'opti' ),
			'id' => 'sidebar-4',
			'description' => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(
		array(
			'name' => __( 'Right Footer Widgets', 'opti' ),
			'id' => 'sidebar-5',
			'description' => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)
	);
	register_sidebar(
		array(
			'name' => __( 'Custom TCB Widget', 'opti' ),
			'id' => 'sidebar-6',
			'description' => '',
			'before_widget' => '<section id="%1$s" class="widget %2$s"><div class="widget-wrap">',
			'after_widget' => '</div></section>',
			'before_title' => '<h4 class="widgettitle">',
			'after_title' => '</h4>',
		)
	);

}

add_action( 'widgets_init', 'opti_widgets_init' );


/**
 * Display the custom header graphic if it's switched on
 */
function opti_custom_header( $position = 'below_nav' ) {

	$header_position = get_option( 'opti_content_header_position', 'below_nav' );

	// if it's the wrong position then leave
	if ( $position != $header_position ) {
		return false;
	}

	$display_header = false;

	if ( is_front_page() && 'homepage' === opti_option( 'display-header-image' ) ) {
		$display_header = true;
	}

	if ( 'all-pages' === opti_option( 'display-header-image' ) ) {
		$display_header = true;
	}

	if ( $display_header ) {

		$header_image = get_header_image();

		if ( ! empty( $header_image ) ) {
?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="header-image">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
<?php
		}
	}
}


/**
 * This is a filter for styling the "Read More" link that appears when creating excerpts
 *
 * @param type $more_link
 * @param type $more_link_text
 * @return type
 */
function opti_more_link( $more_link, $more_link_text ) {

	return str_replace( $more_link_text, __( 'Continue reading &rarr;', 'opti' ), $more_link );

}


/**
 *
 * @param type $position
 */
function opti_navmenu( $position ) {

	$args = array(
		'theme_location' => $position,
		'menu_id' => '',
		'menu_class' => 'nav',
		'fallback_cb' => false,
		'echo' => 0,
	);

	add_filter( 'wp_nav_menu_items', 'opti_nav_menu_items' );
	$menu = wp_nav_menu( $args );
	remove_filter( 'wp_nav_menu_items', 'opti_nav_menu_items' );

	if ( empty( $menu ) ) {
		$args = array(
			'title_li' => '',
			'echo' => 0,
			'orderby' => 'count',
			'order' => 'DESC',
			'number' => 7,
			'depth' => 2,
		);
		?>
		<ul id="nav" class="nav">
			<?php echo opti_nav_menu_items( wp_list_categories( $args ) ); ?>
		</ul>
		<?php
	} else {
		echo $menu;
	}
}


/**
 * Filter wp_nav_menu() to add additional links and other output
 *
 * @param type $items
 * @return type
 */
function opti_nav_menu_items( $items ) {
	$class = array( 'home', 'menu-item' );
	if ( is_home() ) {
		$class[] = 'current-menu-item';
	}
	$homelink = '<li class="' . implode( ' ', $class ) . '"><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'opti' ) . '</a></li>';
	return $homelink . $items;
}


/**
 * Shorter Excerpts
 *
 * @param type $length
 * @return int
 */
function opti_excerpt_length( $length ) {
	return 40;
}


/**
 * wp_page_menu Filter
 *
 * This is a filter that allows a custom ID to be added to your nav
 *
 * @param type $ulclass
 * @return type
 */
function opti_add_menuclass( $ulclass ) {
	return preg_replace( '/<ul>/', '<ul id="nav">', $ulclass, 1 );
}


/**
 * Comments Callback
 *
 * This code abstracts out comment code and makes the markup editable
 *
 * @param type $comment
 * @param type $args
 * @param type $depth
 */
function opti_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment-wrapper">
			<div class="comment-author vcard clearfloat">
				<?php echo get_avatar( $comment, $size = '42' ); ?>
				<div class="commentmetadata">
					<?php printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() ); ?>
					<div class="comment-date">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php printf( __( '%1$s &bull; %2$s', 'opti' ), get_comment_date(), get_comment_time() ); ?>
						</a>
						<?php edit_comment_link( __( 'Edit', 'opti' ) ); ?>
					</div>
				</div>
			</div>
			<?php
			if ( 0 == $comment->comment_approved ) {
				?>
				<p class="comment-mod"><em><?php _e( 'Your comment is awaiting moderation.', 'opti' ); ?></em></p>
				<?php
			}

			comment_text();
			?>
			<div class="reply">
				<?php
				comment_reply_link(
						array_merge( $args, array(
							'depth' => $depth,
							'reply_text' => __( 'Reply &darr;', 'opti' ),
							'login_text' => __( 'Log in to reply', 'opti' ),
							'max_depth' => $args['max_depth'] )
						)
				);
				?>
			</div>
		</div>
<?php
}


/**
 * add a microid to all the comments
 *
 * @param string $classes
 * @return string
 */
function opti_comment_add_microid( $classes ) {
	$c_email = get_comment_author_email();
	$c_url = get_comment_author_url();
	if ( !empty( $c_email ) && !empty( $c_url ) ) {
		$microid = 'microid-mailto+http:sha1:' . sha1( sha1( 'mailto:' . $c_email ) . sha1( $c_url ) );
		$classes[] = $microid;
	}
	return $classes;
}


/**
 * fill empty post thumbnails with images from the first attachment added to a post
 *
 * @param type $html
 * @param type $post_id
 * @param type $thumbnail_id
 * @param type $size
 * @return type
 */
function opti_post_thumbnail_html( $html, $post_id, $thumbnail_id, $size = '' ) {

	if ( empty( $html ) ) {

		$html = '';

		$values = get_attached_media( 'image' );

		if ( $values ) {
			foreach ( $values as $child_id => $attachment ) {
				$html = wp_get_attachment_image( $child_id, $size );
				break;
			}

			// add required image styles
			$html = str_replace( 'attachment-opti-post-loop', 'attachment-opti-post-loop wp-post-image', $html );
			$html = str_replace( 'attachment-opti-featured', 'attachment-opti-featured wp-post-image', $html );
			$html = str_replace( 'attachment-opti-archive', 'attachment-opti-archive wp-post-image', $html );
		}
	}

	return $html;
}


/**
 * Numeric Pagination
 *
 * @global type $wp_query
 * @param type $pageCount
 * @param type $query
 * @return type
 */
function opti_numeric_pagination( $query = null ) {

	global $wp_query, $wp_rewrite;

	if ( ! $query ) {
		$query = $wp_query;
	}

	if ( 1 >= $query->max_num_pages ) {
		return;
	}

	$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args = array();
	$url_parts = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 2,
		'add_args' => array_map( 'urlencode', $query_args ),
		'next_text' => __( 'Older &rsaquo;', 'opti' ),
		'prev_text' => __( '&lsaquo; Newer', 'opti' ),
	) );

	if ( $links ) {
?>
	<nav class="archive-pagination pagination" role="navigation">
		<h1 class="screen-reader"><?php _e( 'Posts navigation', 'opti' ); ?></h1>
		<?php echo $links; ?>
	</nav>
<?php
	}

}


$opti_data = array( );

/**
 * load theme settings
 *
 * load and cache the theme settings in a nice central way. Applies filters,
 * caching, and default values from the off, so values will always have the
 * setting they require. Returns false if a property does not exist
 *
 * @global type $opti_data
 * @param type $property
 * @return type
 */
function opti_option( $property = null ) {

	global $opti_data;

	if ( empty( $opti_data['options'] ) ) {
		$opti_data['options'] = opti_get_theme_options();
	}

	if ( isset( $opti_data['options'][$property] ) ) {
		$data = $opti_data['options'][$property];
	} else if ( $property == null ) {
		$data = $opti_data['options'];
	} else {
		$data = false;
	}

	return apply_filters( 'opti_option', $data, $property );
}


/**
 *
 * @return type
 */
function opti_get_theme_options() {

	$saved = array( );
	$defaults = array( );

	$settings = opti_settings_admin();

	foreach ( $settings as $s ) {
		if ( ! empty( $s['var'] ) ) {
			$saved = array_merge( $saved, (array) get_option( opti_option_name( $s['var'] ) ) );

			foreach ( $s['fields'] as $f ) {
				if ( isset( $f['default'] ) ) {
					$defaults[$f['var']] = $f['default'];
				} else {
					$defaults[$f['var']] = false;
				}
			}
		}
	}

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );

	return $options;
}


/**
 *
 * @param type $name
 * @return type
 */
function opti_option_name( $name ) {

	$name = str_replace( ' ', '_', $name );
	return OPTI_OPTION_PREFIX . '_' . strtolower( $name );
}


/**
 * add new theme settings/ properties
 *
 * add new properties into the global theme cache
 *
 * @global type $opti_data
 * @param type $property
 * @param type $value
 */
function opti_option_add( $property = null, $value = '' ) {

	global $opti_data;

	if ( $property !== null ) {
		$opti_data[$property] = $value;
	}
}


/**
 * get custom post meta info for individual posts
 *
 * A standardized method for getting data from a post. It could be done as a
 * series of get_post_meta calls, but this centralises the requests, caches the
 * data and means I don't have to remember custom field id's
 *
 * @global type $opti_data
 * @global type $post
 * @param type $property
 * @return type
 */
function opti_post_meta( $property ) {

	global $opti_data, $post;

	if ( empty( $post ) ) {
		return false;
	}

	// check cache and if empty load from post_meta
	if ( empty( $opti_data['post_meta'][$post->ID] ) ) {
		$opti_data['post_meta'][$post->ID] = get_post_meta( $post->ID, 'opti_postSettings', true );
	}

	if ( isset( $opti_data['post_meta'][$post->ID][$property] ) ) {
		return $opti_data['post_meta'][$post->ID][$property];
	} else if ( $property == null ) {
		return $opti_data['post_meta'][$post->ID];
	} else {
		return false;
	}
}


/**
 *
 * @return type
 */
function opti_get_homepage_categories() {

	$categories = array( );

	if ( !opti_option( 'hide-homepage-categories' ) ) {
		$categories = opti_option( 'homepage-categories' );

		if ( empty( $categories ) ) {
			$temp_categories = get_categories( array(
				'orderby' => 'count',
				'order' => 'desc',
				'number' => 3,
					) );

			foreach ( $temp_categories as $tc ) {
				$categories[] = $tc->term_id;
			}
		}
	}

	return $categories;
}


/**
 *
 * @param type $echo
 * @return string
 */
function opti_content_class( $echo = true ) {

	$content_class = 'eightcol';
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_class .= ' full-width';
	}

	if ( $echo ) {
		echo $content_class;
	} else {
		return $content_class;
	}

}


/**
 * WP.com theme stuff
 */
global $themecolors, $content_width;

$themecolors = array(
	'bg' => 'ffffff',
	'border' => 'eeeeee',
	'text' => '1B1B1B',
	'link' => '3399CC',
	'url' => '59BCED',
);

if ( ! isset( $content_width ) ) {
	$content_width = 700;
}


/**
 *
 * @global type $content_width
 */
function opti_set_content_width() {

	global $content_width;

	if ( is_singular() && 'eightcol full-width' == opti_content_class( false ) || is_page_template( 'custom-page-fullwidth.php' ) ) {
		$content_width = 1032;
	}

}


/**
 *
 * @param type $content
 * @return type
 */
function opti_replace_excerpt( $content = '' ) {

	return sprintf( __( '... <a href="%s" class="read-more">Read More &rsaquo;</a>', 'opti' ), esc_url( get_permalink() ) );

}

add_action( 'template_redirect', 'opti_set_content_width' );


/**
 * Calculate breadcrumbs for any page on the site
 *
 * @param boolean $display display or return the results as an array?
 * @param string $seperator the text to place between the crumbs when returned as a string
 * @return array list of name, url pairs to use to create breadcrumbs
 */
function opti_simpleBreadcrumbs ($display = TRUE, $separator = '<b>&rsaquo;</b>') {

	// don't display breadcrumbs on the homepage
	if (is_front_page ()) {
		return false;
	}

	global $wp_query, $post, $bm_crumbLinks, $bm_postMeta;

	// always a home link
	$bm_crumbLinks[] = array (
		__('Home', 'opti'),
		home_url()
	);

	// add breadcrumbs for custom post types
	$post_type = get_post_type ($post);

	if (!in_array ($post_type, array ('post', 'page', 'attachment', ''))) {
		$post_type_object = get_post_type_object ($post_type);
		if (isset ($post_type_object->labels->name)) {
			$bm_crumbLinks[] = array (
				$post_type_object->labels->name,
				get_post_type_archive_link ($post_type),
			);
		}
	}

	// is it the front page?
	if (is_home () || is_front_page ()) {

		// turn off url on home link to keep it as text
		$links[0][1] = '';

	// a page?
	} else if (is_page ()) {

		$post = $wp_query->get_queried_object ();
		if ( 0 < $post->post_parent ) {

			$bm_crumbLinks[] = array(
				get_the_title (),
				get_permalink (),
			);

		} else {

			// Reverse the order so it's oldest to newest
			if (isset ($post->ancestors)) {
				$ancestors = array_reverse ($post->ancestors);
			} else {
				$ancestors[] = $post->post_parent;
			}

			// Add the current Page to the ancestors list (as we need it's title too)
			$ancestors[] = $post->ID;

			foreach ($ancestors as $ancestor) {
				$bm_crumbLinks[] = array (
					strip_tags (get_the_title ($ancestor)),
					get_permalink ($ancestor),
				);
			}

		}

	// anything else?
	} else {

		if (is_attachment ()) {
			$bm_crumbLinks[] = array(
				get_the_title ($post->post_parent),
				get_permalink ($post->post_parent),
			);
		} else if (is_single ()) {
			$cats = get_the_category ();
			if (isset ($cats[0])) {
				$cat = $cats[0];
				opti_get_category_parents ($cat->term_id);
			}
		}

		if (is_category ()) {
			$cat = (int) get_query_var ('cat');
			opti_get_category_parents ($cat);
		} else if (is_tag ()) {
			$bm_crumbLinks[] = array (
				single_cat_title ('', FALSE),
			);
		} elseif (is_date ()) {
			$day = (int) $wp_query->query_vars['day'];
			$month = (int) $wp_query->query_vars['monthnum'];
			$year = (int) $wp_query->query_vars['year'];

			if ($month != 0) {
				$title = single_month_title (' ', FALSE);
			} else {
				$title = $year;
			}

			$bm_crumbLinks[] = array (
				$title,
				opti_getDateArchiveLink ($year, $month, $day),
			);
		} elseif (is_post_type_archive ()) {
			// do nothing - it was taken care of earlier
		} elseif (is_author ()) {
			$curauth = $wp_query->get_queried_object ();
			$bm_crumbLinks[] = $curauth->display_name;
		} elseif (is_search ()) {
			$bm_crumbLinks[] = sprintf (__('Search : ', 'mimbopro'), get_search_query ());
		} elseif (is_404 ()) {
			$bm_crumbLinks[] = __('404 Page not found', 'mimbopro');
		} else {
			$title = get_the_title ();
			if (!empty ($bm_postMeta['seo_breadcrumbTitle'])) {
				$title = $bm_postMeta['seo_breadcrumbTitle'];
			}
			$bm_crumbLinks[] = array (
				$title,
				get_permalink(),
			);
		}

	}

	if (!empty ($wp_query->query_vars['paged'])) {
		$bm_crumbLinks[] = sprintf (__('Page %d', 'mimbopro'), $wp_query->query_vars['paged']);
	}

	if (!empty ($wp_query->query_vars['page'])) {
		$bm_crumbLinks[] = sprintf (__('Page %d', 'mimbopro'), $wp_query->query_vars['page']);
	}

	$bm_crumbLinks = apply_filters ('bm_crumbLinks', $bm_crumbLinks);

	$count = 0;
	$crumbs = array ();

	foreach ($bm_crumbLinks as $link) {
		$count ++;
		$link = (array) $link;

		$htmlClass = 'breadcrumbLevel_' . $count;

		if ($link[0] != '') {
			if ($count != count ($bm_crumbLinks)) {
				$crumbs[] = '<a href="' . $link[1] . '" class="' . $htmlClass . '">' . $link[0] . '</a>';
			} else {
				$crumbs[] = '<strong class="' . $htmlClass . '">' . $link[0] . '</strong>';
			}
		}
	}

	if ($crumbs) {
		if ($display) {
			echo '<p class="breadcrumbs postmetadata">' . implode (' ' . $separator . ' ', $crumbs) . '</p>';
		} else {
			return $crumbs;
		}
	}

	return FALSE;

}

/**
 * Get the parents of a category and update the bm_crumblinks array with the result
 *
 * @param int $id the id of the category
 */
function opti_get_category_parents ($id) {

	global $bm_crumbLinks;

	$parent = get_category ($id);

	if (!is_wp_error ($parent)) {
		if ($parent->parent && ($parent->parent != $parent->term_id)) {
			opti_get_category_parents ($parent->parent);
		}
	}

	$bm_crumbLinks[] = array($parent->name, get_category_link ($parent->term_id));

	return true;

}

/**
 *
 * @global <type> $wp_rewrite
 * @param <type> $year
 * @param <type> $month
 * @param <type> $day
 * @return <type>
 */
function opti_getDateArchiveLink ($year = 0, $month = 0, $day = 0) {

	global $wp_rewrite;

	if ($day == 0 && $month == 0) {
		$link = $wp_rewrite->get_year_permastruct ();
	} else if ($day == 0) {
		$link = $wp_rewrite->get_month_permastruct ();
	} else {
		$link = $wp_rewrite->get_day_permastruct ();
	}

	if (!empty ($link)) {
		$link = str_replace ('%year%', $year, $link);
		$link = str_replace ('%monthnum%', zeroise (intval ($month), 2), $link);
		$link = str_replace ('%day%', zeroise (intval ($day), 2), $link);
		$link = user_trailingslashit ($link, 'day');
	} else {
		$link = '/?m=' . $year . zeroise ($month, 2) . zeroise ($day, 2);
	}

	return apply_filters ('bm_getDateArchiveLink', esc_url( home_url( '/' ) ) . $link, $year, $month, $day);

}


/**
 *
 * @global type $post
 */
function opti_related_posts() {

	global $post;
	$categories = get_the_category();
	$cat_list = array();
	foreach ( $categories as $c ) {
		$cat_list[] = $c->term_id;
	}

	return array(
		'cat' => implode( $cat_list, ',' ),
		'posts_per_page' => 6,
		'post__not_in' => array($post->ID),
	);

}


/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * borrowed from TwentyThirteen
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function opti_wp_title( $title, $sep ) {

	global $page, $paged;

	if ( is_feed() ) {
		return $title;
	}

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description";
	}

	// Add a page number if necessary:
	if ( 2 <= $paged || 2 <= $page ) {
		$title .= " $sep " . sprintf( __( 'Page %s', 'opti' ), max( $paged, $page ) );
	}

	return $title;

}

add_filter( 'wp_title', 'opti_wp_title', 10, 2 );


add_action( 'wp_enqueue_scripts', 'opti_scripts_init' );
add_action( 'wp_enqueue_scripts', 'opti_styles_init' );
add_action( 'customize_register', 'opti_customize_register' );
if ( ! is_admin() ) {
	add_action( 'wp_print_scripts', 'opti_head_styles' );
}

add_filter( 'opti_styles', 'opti_colour_styles' );
add_filter( 'post_class', 'opti_oddeven_post_class' );
add_filter( 'excerpt_more', 'opti_replace_excerpt' );
add_filter( 'the_content_more_link', 'opti_more_link', 10, 2 );
add_filter( 'excerpt_length', 'opti_excerpt_length', 999 );
add_filter( 'wp_page_menu', 'opti_add_menuclass' );
add_filter( 'post_thumbnail_html', 'opti_post_thumbnail_html', 10, 4 );
// add category nicenames in body and post class
function category_id_class( $classes ) {
	global $post;
	foreach ( get_the_category( $post->ID ) as $category ) {
		$classes[] = $category->category_nicename;
	}
	return $classes;
}
add_filter( 'post_class', 'category_id_class' );
add_filter( 'body_class', 'category_id_class' );


function is_subcategory (){
    $cat = get_query_var('cat');
    $category = get_category($cat);
	$category->parent;
    return ( $category->parent == '0' ) ? false : true;
}

add_action( 'pre_get_posts', 'foo_modify_query_exclude_category' );
function foo_modify_query_exclude_category( $query ) {
    if ( ! is_admin() && $query->is_home() && $query->is_main_query() && ! $query->get( 'cat' ) )
        $query->set( 'cat', '-950' );
}
add_filter('found_posts', 'myprefix_adjust_offset_pagination', 1, 2 );

function myprefix_adjust_offset_pagination($found_posts, $query) {

    //Define our offset again...
    $offset = 10;

    //Ensure we're modifying the right query object...
    if ( $query->is_posts_page ) {
        //Reduce WordPress's found_posts count by the offset...
        return $found_posts - $offset;
    }
    return $found_posts;
}