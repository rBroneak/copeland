<?php
/**
 * Archive pagination
 *
 * @package Opti
 */
?>
<ul id="pagination">
	<li id="older">
		<?php next_posts_link( __( '&lsaquo; Older Entries', 'opti' ) ); ?>
	</li>
	<li id="newer">
		<?php previous_posts_link( __( 'Newer Entries &rsaquo;', 'opti' ) ); ?>
	</li>
</ul>