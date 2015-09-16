<?php
/**
 * Display the loop for archive pages
 *
 * @package Opti
 */
?>

<?php
$queryString = $_SERVER['QUERY_STRING'];
$queryCat = get_cat_ID( $queryString );
$catName = $_GET['cat'];

if (isset($catName)) {
	$tom_query = new WP_Query();
	$args = array(
		'posts_per_page' => 1,
		'cat' => $title,
		'category__in' => array($catName, 951),
		'category__and' => array($catName, 951)
	);
} else {
	$tom_query = new WP_Query();
	$args = array(
		'cat' => $title,
		'category__in' => array(951),
		'posts_per_page' => 1,
		'category__not_in' => 950
	);
}


$tom_query  = new WP_Query( $args );

//echo '<h2>Test include'.$title.'</h2>';
while( $tom_query->have_posts() ) {
	$tom_query->the_post();
	get_template_part('content' , 'top-archive');
}
wp_reset_postdata();




?>