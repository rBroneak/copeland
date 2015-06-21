<?php
/**
 * Homepage template
 *
 * @package Opti
 */

get_header();

$display_categories = opti_get_homepage_categories();
$showposts = (int) opti_option( 'featured-posts' );

$recent_colwidth = 'ninecol';
if ( empty( $display_categories ) ) {
	$recent_colwidth = 'twelvecol';
}

?>
<!--
<div class="row">
<div  class="<?php echo $recent_colwidth; ?>">
	<h3>ASK Tom</h3>
	<h3>Question: Can I deduct the cost of plowing my driveway? Answer</h3>
</div>
</div>
-->
<section class="row">
	<div class="<?php opti_content_class(); ?>">
	
	
<?php
		$paged = get_query_var( 'paged' ) ? (int) get_query_var( 'paged' ) : 1;
		$page_title = __( 'Recent Posts', 'opti' );
		$ignore_post = -1;

		if ( $paged == 1 ) {
			get_template_part( 'includes/featured' );
		} else {
			$page_title = sprintf( __( 'Recent Posts - page %d', 'opti' ), $paged );
		}

		if ( have_posts() ) {
?>
		<div id="recent-posts" class="<?php echo $recent_colwidth; ?>">
			<h3><?php echo $page_title; ?></h3>
			<ul id="recent-excerpts">
<?php
			while( have_posts() ) {
				the_post();
				if ( $post->ID != $ignore_post ) {
					get_template_part( 'content', 'home-loop' );
				}
			}
?>
			</ul>
<?php
		get_template_part( 'includes/pagination' );
?>
		</div><!--END RECENT/OLDER POSTS-->
<?php
		}

		if ( $display_categories && is_array( $display_categories ) ) {
?>
		<section id="featured-cats" class="threecol quick-links">
			<ul>
			<li>
				<?php 
					dynamic_sidebar( 'sidebar-6' );
				?>
			</li>
			</ul>
			<ul>
				<li>				
				<div class="fb-like-box widget" data-href="https://www.facebook.com/TomCopelandblog" data-width="209" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="false" data-show-border="false"></div>
				</li>
			</ul>
		</section><!--END FEATURED CATS-->
			<?php
		}
		?>
			</div>
	
	<?php get_sidebar(); ?>
</section>
<?php
	get_footer();
