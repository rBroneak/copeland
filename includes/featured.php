<?php
/**
 * Featured content loop
 *
 * @package Opti
 */

	if ( opti_has_featured_posts() ) {
?>
	<section id="lead-story" class="lead-featured">
<?php
		$featured_posts = opti_get_featured_posts( 4 );
		foreach ( $featured_posts as $post ) {
			setup_postdata( $post );
			get_template_part( 'content-featured' );
		}
?>
	</section>
<?php
	// only show this on the homepage as per previous behaviour
	} else if ( is_front_page() ) {

		global $ignore_post;

		$args = array(
			'paged' => 1,
			'posts_per_page' => 1,
			'ignore_sticky_posts' => 1,
		);
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$ignore_post = $query->post->ID;
				$query->the_post();
?>
	<section id="lead-story" class="lead-latest">
<?php
		get_template_part( 'content-featured' );
?>
	</section>
<?php
			}
		}
		wp_reset_postdata();

	}