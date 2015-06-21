<?php
/**
 * Display data relevant to blog posts
 *
 * @package Opti
 */
?>
<p class="postmetadata">
<?php
	printf( __( '<time class="entry-date" datetime="%3$s">%4$s</time>', 'opti' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'opti' ), get_the_author() ) ),
		get_the_author()
	);

/*
	if ( $post->comment_status == 'open' ) {
?>
	&bull; <span class="commentcount">( <?php comments_popup_link( '0', '1', '%', 'comments_link', '' ); ?> )</span>
<?php
	}
*/
?>
</p>