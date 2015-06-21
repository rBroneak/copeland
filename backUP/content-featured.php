<?php
/**
 * Display featured content posts
 *
 * @package Opti
 */
?>
	<article class="item">
<?php
	if ( get_the_post_thumbnail( get_the_ID(), 'opti-featured' ) ) {
?>
		<a class="noborder lead-image" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>">
			<?php the_post_thumbnail( 'opti-featured' ); ?>
		</a>
<?php
	}
?>
		<h2 class="posttitle">
			<a class="dark" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a>
		</h2>
<?php
	get_template_part( '/includes/postmetadata' );
?>
		<div class="excerpt">
<?php
	the_excerpt();
?>
		</div>
	</article>