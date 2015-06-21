<?php
/**
 * List content archive
 *
 * @package Opti
 */

get_header();
?>

<section class="row">
	<div class="eightcol full-width">
		<?php
		if ( have_posts() ) {
			if ( is_category() || is_tax( 'jetpack-portfolio-type' ) ) {

				$title = single_cat_title( '', false );

			} elseif ( is_tag() ) {

				$title = single_tag_title( '', false );

			} elseif ( is_author() ) {

				$title = sprintf( __( 'Author: %s', 'opti' ), '<span class="vcard">' . get_the_author() . '</span>' );

			} elseif ( is_day() ) {

				$title = sprintf( __( 'Day: %s', 'opti' ), '<span>' . get_the_date() . '</span>' );

			} elseif ( is_month() ) {

				$title = sprintf( __( 'Month: %s', 'opti' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'opti' ) ) . '</span>' );

			} elseif ( is_year() ) {

				$title = sprintf( __( 'Year: %s', 'opti' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'opti' ) ) . '</span>' );

			} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {

				$title = __( 'Asides', 'opti' );

			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {

				$title = __( 'Galleries', 'opti');

			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {

				$title = __( 'Images', 'opti');

			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = __( 'Videos', 'opti' );

			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {

				$title = __( 'Quotes', 'opti' );

			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {

				$title = __( 'Links', 'opti' );

			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {

				$title = __( 'Statuses', 'opti' );

			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {

				$title = __( 'Audios', 'opti' );

			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {

				$title = __( 'Chats', 'opti' );

			} else {

				$title = __( 'Archives', 'opti' );

			}
?>
		<h1 class="pagetitle"><?php echo $title; ?></h1>
<?php
			if ( is_category() ) {
				$description = category_description();
				if ( ! empty( $description ) ) {
					echo '<div class="category_description">' . $description . '</div>';
				}
			}
?>
		<div class="masonry-wrapper">
<?php
			while ( have_posts() ) {
				the_post();
				get_template_part( 'content', 'archive' );
			}
?>
		</div>
<?php
			opti_numeric_pagination();
		} else {
?>
			<h2><?php _e( 'Not Found', 'opti' ); ?></h2>
<?php
		}
?>
	</div>
</section>
<?php
	get_footer();