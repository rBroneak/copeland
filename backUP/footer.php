<?php
/**
 * Footer code and content
 *
 * @package Opti
 */
?>		</section>
	</section>
</section>

<footer role="contentinfo">
	<section class="row">
<?php
 	if ( is_active_sidebar( 'sidebar-2' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-2' );
		echo '</section>';
 	}
	if ( is_active_sidebar( 'sidebar-3' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-3' );
		echo '</section>';
	}
	if ( is_active_sidebar( 'sidebar-4' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-4' );
		echo '</section>';
	}
	if ( is_active_sidebar( 'sidebar-5' ) ) {
		echo '<section class="col">';
		dynamic_sidebar( 'sidebar-5' );
		echo '</section>';
	}
?>
	</section>
	<section id="footer-wrap">
		<section class="row">
			 <p>&copy; Tom Copeland <?php echo date("Y"); ?></p>
		</section>
	</section>
</footer>
<?php wp_footer(); ?>
</body>
</html>