<?php
/**
 * Display the loop for the home page and other pages with lists of content
 *
 * @package Opti
 */
?>

<?php

//if ( !in_category( 'ask-tom' )) {
//			if( !get_field('hidden_post')) {

	?>
	<li <?php post_class(); ?>>
		<h4><a class="dark" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'opti' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a></h4>
		<?php
		get_template_part( '/includes/postmetadata' );
		?>
		<div class="excerpt">
			<?php if ( get_the_post_thumbnail( get_the_ID(), 'opti-post-loop' ) ) { ?>
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'opti-post-loop' ); ?></a>
			<?php } ?>
			<?php the_excerpt(); ?>
		</div>
	</li><!--/RECENT EXCERPTS-->
<?php

//}
//		}

?>