<?php
/**
 * Single blog post
 *
 * @package Opti
 */

get_header();
?>
<section class="row">
	<div class="<?php opti_content_class(); ?>">
<?php
	opti_simpleBreadcrumbs();

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content-single' );
			get_template_part( 'includes/pagination' );
			comments_template( '', true );
		}
	}
?>
	</div>
	<?php get_sidebar(); ?>
</section>
<?php
get_footer();