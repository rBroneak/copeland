<?php
$category = get_the_category();
?>


    <aside class="fourcol last ask-tom-widget">
        <div class="widget-wrap">
            <?php
            $cat_id = 950; //the certain category ID
            $latest_cat_post = new WP_Query( array('posts_per_page' => 1, 'category__in' => array($cat_id)));
            if( $latest_cat_post->have_posts() ) : while( $latest_cat_post->have_posts() ) : $latest_cat_post->the_post();  ?>

                <h3 class="widgettitle">Ask Tom</h3>
                <h3 class="tom-title">Question: <?php the_title(); ?></h3>
                <a href="/category/ask-tom">View Answer</a>

            <?php endwhile; endif; ?>

            <?php

            echo '<div class="wrap"><h3 class="tom-title">Have a Question? ';
            echo '<a href="/ask-tom">Ask Tom</a></h3></div> ';

            ?>
        </div>
    </aside>



