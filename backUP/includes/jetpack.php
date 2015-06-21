<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Opti
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function opti_infinite_scroll_init() {

	add_theme_support( 'infinite-scroll', array(
		'container' => 'recent-excerpts',
		'footer_widgets' => ( ( ( class_exists( 'Jetpack_User_Agent_Info' ) && method_exists( 'Jetpack_User_Agent_Info', 'is_ipad' ) && Jetpack_User_Agent_Info::is_ipad() ) || ( function_exists( 'jetpack_is_mobile' ) && jetpack_is_mobile() ) ) || is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) || is_active_sidebar( 'sidebar-4' ) || is_active_sidebar( 'sidebar-5' ) ),
		'render'    => 'opti_infinite_scroll_render',
		'footer'    => 'main',
	) );

	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'opti_get_featured_posts',
		'max_posts'   => 4,
	) );

	add_theme_support( 'jetpack-responsive-videos' );

	add_theme_support( 'site-logo' );

}

add_action( 'after_setup_theme', 'opti_infinite_scroll_init' );


/**
 * Set the code to be rendered on for calling posts, hooked to template parts when possible.
 *
 * Note: must define a loop.
 */
function opti_infinite_scroll_render() {

	while ( have_posts() ) {
		the_post();
		get_template_part( 'content', 'home-loop' );
	}

}


/**
 * Get featured posts using Jetpack Featured content
 */
function opti_get_featured_posts() {

	return apply_filters( 'opti_get_featured_posts', array() );

}


/**
 * Check if Jetpack Featured Content has any featured posts available
 *
 * @param type $minimum
 * @return boolean
 */
function opti_has_featured_posts( $minimum = 1 ) {

    if ( is_paged() ) {
        return false;
	}

	if ( ! is_front_page() ) {
		return false;
	}

    $minimum = absint( $minimum );
    $featured_posts = apply_filters( 'opti_get_featured_posts', array() );

    if ( ! is_array( $featured_posts ) ) {
        return false;
	}

    if ( $minimum > count( $featured_posts ) ) {
        return false;
	}

    return true;

}