<?php
/**
 * Display file attachments
 *
 * @package Opti
 */

get_header();
?>

<section class="row">
	<div class="eightcol">
<?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', 'attachment' );
			comments_template( '', true );
		}
	}
?>
	</div>

	<?php get_sidebar(); ?>

</section>
<?php
	get_footer();