<?php
/**
 * Error - file not found
 *
 * @package Opti
 */

	get_header();
?>
<section class="row">
	<div class="eightcol">
		<article>
			<h1 class="pagetitle"><?php _e( 'Error 404', 'opti' ); ?></h1>
			<h3><?php _e( 'Oops!', 'opti' ); ?></h3>
			<p><?php _e( 'Sorry, but the page you are looking for has not been found. Try checking the URL for errors, then hit the refresh button in your browser.', 'opti' ); ?></p>
		</article>
	</div>
	<?php get_sidebar(); ?>
</section>
<?php
	get_footer();