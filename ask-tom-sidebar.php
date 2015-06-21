<?php 
$category = get_the_category();

if ( !in_category('Ask Tom')) { ?>

<aside class="fourcol last">
<?php
    $cat_id = 950; //the certain category ID
	$latest_cat_post = new WP_Query( array('posts_per_page' => 1, 'category__in' => array($cat_id)));
	if( $latest_cat_post->have_posts() ) : while( $latest_cat_post->have_posts() ) : $latest_cat_post->the_post();  ?>

		<h3 class="widgettitle">Ask Tom</h3>
		<h3>Question: <?php the_title(); ?></h3>
	    <a href="index.php?cat=950">View Answer</a>

		<?php endwhile; endif; ?>

</aside>
<?php
 } else {
 
 }
?>


