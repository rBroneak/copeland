<?php
/**
 * Static page layout
 *
 * @package Opti
 */

get_header();

get_template_part( 'includes/featured' );
?>
<section class="row">
	<div class="<?php opti_content_class(); ?>">
<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'page' );
			comments_template( '', true );
		}
	}
?>
	</div>
	<?php get_sidebar(); ?>
</section>
<?php
	get_footer();