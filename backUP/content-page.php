<?php
/**
 * Display the loop for generic pages
 *
 * @package Opti
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<h1 class="pagetitle">
		<?php the_title(); ?> <?php get_template_part( '/includes/edit' ); ?>
	</h1>
	<section class="entry">
<?php
		the_content();

		// link pages together
		wp_link_pages( array(
			'before' => '<p class="archive-pagination">' . __( 'Pages: ', 'opti' ),
			'after'  => '</p>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
		) );
?>
	</section>
</article>
