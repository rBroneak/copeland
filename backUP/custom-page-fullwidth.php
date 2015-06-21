<?php
/**
 * Template Name: Full Width
 * Full width custom page template
 *
 * @package Opti
 */

get_header();

get_template_part( 'includes/featured' );

?>
<section class="row">
	<div class="eightcol full-width">
<?php
	while ( have_posts() ) {
		the_post();
?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<h1 class="pagetitle">
					<?php the_title(); ?> <?php get_template_part( '/includes/edit' ); ?>
				</h1>
				<section class="entry">
<?php
		the_content();

		// link pages together
		wp_link_pages( array(
			'before' => '<p class="archive-pagination">' . __( 'Pages: ', 'opti' ),
			'after'  => '</p>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
?>
				</section>
			</article>
<?php
		comments_template();
	}
?>
	</div>
</section>
<?php
	get_footer();