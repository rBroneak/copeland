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

		</a>
	</div>
	<div class="excerpt-wrap">
		<h2 class="posttitle">
			<em>Question:</em> <?php the_title(); ?>
		</h2>
		<?php the_content(); ?>
	</div>
</article>


