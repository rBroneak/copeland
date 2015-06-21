<?php
/**
 * Template Name: Archives
 * Historical archives custom page template
 *
 * @package Opti
 */

get_header();

get_template_part( 'includes/featured' );

?>

<section class="row">
	<div class="eightcol">

		<h1 class="pagetitle">
			<?php the_title(); ?> <?php get_template_part( '/includes/edit' ); ?>
		</h1>

		<div class="post">
			<div class="entry">
<?php
	$query = new WP_Query( array(
		'paged' => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
		'posts_per_page' => 50,
	) );

	$previous_year = 0;
	$previous_month = 0;
	$ul_open = false;

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$year = mysql2date( 'Y', $query->post->post_date );
			$month = mysql2date( 'n', $query->post->post_date );

			if ( $year != $previous_year || $month != $previous_month ) {
				if ( $ul_open == true ) {
?>
					</ul>
<?php
				}
?>
				<h3><?php the_date( 'F o' ); ?></h3>
				<ul id="archive-list">
<?php
				$ul_open = true;
			}

			$previous_year = $year;
			$previous_month = $month;
?>
				<li><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></li>
<?php
		}
	}
?>
				</ul>
<?php
	opti_numeric_pagination( $query );
	wp_reset_postdata();
?>
			</div>
		</div>
	</div>
	<?php get_sidebar(); ?>

</section>

<?php
	get_footer();