<?php
/**
 * Display the loop for single post pages
 *
 * @package Opti
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="posttitle">
		<?php the_title(); ?> <?php get_template_part( '/includes/edit' ); ?>
	</h1>
	<?php get_template_part( '/includes/postmetadata' ); ?>
	<section class="entry">
<?php
		the_content();

		echo '<hr class="sep" />';

		// link pages together
		wp_link_pages( array(
			'before' => '<p class="archive-pagination">' . __( 'Pages: ', 'opti' ),
			'after'  => '</p>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );

		// article navigation
		previous_post_link( '<div class="postnav left">&lsaquo; %link</div>' );
		next_post_link( '<div class="postnav right">%link &rsaquo;</div>' );

		echo '<hr class="sep" />';

		// categories
		echo '<p class="post-taxonomies post-taxonomies-categories">' . __( 'Categories: ', 'opti' );
		the_category( ', ' );
		echo '</p>';

		// tags
		if ( get_the_tags() ) {
			the_tags( '<p class="post-taxonomies post-taxonomies-tags">' . __( 'Tags: ', 'opti' ), ', ', '</p>' );
		}

		// related posts
		// -------------
		if ( is_single() && opti_option( 'display-related-posts' ) ) {

			$query = new WP_Query( opti_related_posts() );

			if ( $query->have_posts() ) {
?>
				<section id="related-posts">
					<h5 class="widgettitle"><?php _e( 'Related Articles', 'opti' ); ?></h5>
					<ul>
<?php
				$i = 0;
				while ( $query->have_posts() ) {
					$query->the_post();
					$i++;
?>
							<li class="<?php echo esc_attr( 'related-' . $i ); ?>">
								<a class="dark" href="<?php the_permalink(); ?>">
<?php
					if ( get_the_post_thumbnail( get_the_ID(), 'opti-post-loop' ) ) {
						the_post_thumbnail( 'opti-post-loop' );
					}
					the_title();
?>
								</a>
							</li>
<?php
				}
?>
					</ul>
				</section>
<?php
			}

			wp_reset_postdata();
		}
?>
	</section>
</article>
