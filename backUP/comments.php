<?php
/**
 * Comments template.
 *
 * @package Opti
 */

// Do not delete these lines
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
	die( __( 'Please do not load this page directly. Thanks!', 'opti' ) );
}

if ( post_password_required() ) {
	return;
}
// Show the comments
if ( have_comments() ) {
?>
	<h3 id="comments">
<?php
		printf( _n( '1 reply', '%1$s replies', get_comments_number(), 'opti' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
?>
		<a href="#respond" title="<?php esc_attr_e( 'Leave a comment &rsaquo;', 'opti' ); ?>"></a>
	</h3>
	<ol class="commentlist" id="singlecomments">
		<?php wp_list_comments( 'type=comment&callback=opti_comment' ); ?>
	</ol>
	<div id="pagination">
		<div class="older">
			<?php previous_comments_link( __( '&lsaquo; Older Comments', 'opti' ) ); ?>
		</div>
		<div class="newer">
			<?php next_comments_link( __( 'Newer Comments &rsaquo;', 'opti' ) ); ?>
		</div>
	</div>
	<?php
}

if ( ! empty( $comments_by_type['pings'] ) ) {
?>
		<h3 id="trackbacks"><?php _e( 'Trackbacks', 'opti' ); ?></h3>
		<ol id="trackbacklist">
<?php
		foreach ( $comments_by_type['pings'] as $comment ) {
?>
					<li id="comment-<?php comment_ID(); ?>">
						<cite><?php comment_author_link(); ?></cite>
					</li>
<?php
		}
?>
		</ol>
<?php
	}

	if ( 'open' == $post->comment_status ) {
?>
	<div id="respond">
		<?php comment_form(); ?>
	</div>
<?php
	}