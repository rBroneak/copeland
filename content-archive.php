<?php
/**
 * Display the loop for archive pages
 *
 * @package Opti
 */
?>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="thumb-wrap">
		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>">
		<?php
			if ( get_the_post_thumbnail( get_the_ID(), 'opti-archive' ) ) {
				the_post_thumbnail( 'opti-archive' );
			}
		?>
		</a>
	</div>
	<div class="excerpt-wrap">
		<h2 class="posttitle">
			<a class="dark" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>
		<?php get_template_part( '/includes/postmetadata' ); ?>
		<section class="entry">
			<?php the_excerpt(); ?>
		</section>
	</div>
</article>