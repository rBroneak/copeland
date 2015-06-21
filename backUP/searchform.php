<?php
/**
 * Search form
 *
 * @package Opti
 */
?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" placeholder="Search" class="searchfield" /><input type="image" src="<?php echo get_template_directory_uri(); ?>/images/magnify.png" class="searchsubmit" alt="<?php esc_attr_e( 'Search', 'opti' ); ?>" />
</form>