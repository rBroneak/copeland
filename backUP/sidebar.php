<?php
/**
 * Sidebar widgets
 *
 * @package Opti
 */

	if ( is_active_sidebar( 'sidebar-1' ) ) {
?>
<aside class="fourcol last">
<?php
		do_action( 'before_sidebar' );
		dynamic_sidebar( 'sidebar-1' );
		
?>

	
</aside>
<?php
	}