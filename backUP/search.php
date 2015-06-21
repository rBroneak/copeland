<?php
/**
 * Search results
 *
 * @package Opti
 */

get_header();
?>
<section class="row">
	<div class="eightcol full-width">
		<h1 class="pagetitle">
			<?php printf( __( 'Search results for &#8216;<em>%s</em>&#8217;', 'opti' ), get_search_query() ); ?>
		</h1>
		<?php
		if ( have_posts() ) {
?>
		<div class="masonry-wrapper">
<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'archive' );
			}
?>
		</div>
<?php
			opti_numeric_pagination();
		} else {
			?>
			<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'opti' ); ?></p>
			<?php
			get_search_form();
		}
?>
	</div>
</section>
<?php
	get_footer();