<?php
/**
 * List content archive
 *
 * @package Opti
 */

get_header();
//local http://$_SERVER[HTTP_HOST]/wordpress
//live http://$_SERVER[HTTP_HOST]/
$actual_link = "http://$_SERVER[HTTP_HOST]/wordpress";

?>

<section class="row">
	<div class="<?php opti_content_class(); ?>">
		<?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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

		<?php
			$catName = $_GET['cat'];
			if (isset($catName)) {
				echo '<h1 class="pagetitle">';
				echo '<a href="'.get_category_link($cat).'">';
				echo $title .'</a> > ';
				echo get_cat_name($catName) . '</h1>';
			} else {
				echo '<h1 class="pagetitle">'.$title.'</h1>';
			}
		?>


		<!-- SHOW SUBCAT MENUE -->
		<?php
		$category = get_category($catid);
		//PARENT SUB NAV
		if ( is_category() ) {
			global $ancestor;
			$childcats = get_categories('child_of=' . $cat . '&hide_empty=1');
			$queryCat = $_GET['cat'];
			if (count($childcats) > 0 ) {
				echo '<nav class="menu clearfloat" id="nav-lower">
						<section class="clearfloat">
							<div class="menu-subcategories-container">
								<ul class="nav">';
								foreach ($childcats as $childcat) {
								  if (cat_is_ancestor_of($ancestor, $childcat->cat_ID) == false) {
								  	if ($queryCat != $childcat->cat_ID) {
									    echo '<li><a href="'.get_category_link($cat).'/?cat='.$childcat->cat_ID.'">';
									    echo $childcat->cat_name . '</a>';
									    echo '</li>';
									    $ancestor = $childcat->cat_ID;
								    }
								  }
								}
								echo '</ul>
							</div>
					  </section>
					</nav>';
			}
			//SUB CATEGORY SUB NAV
			 if ( is_subcategory() ) {
			 $pcat = $_SERVER['QUERY_STRING'];
			 $childcats = get_categories('child_of=' . $pcat . '&hide_empty=1');

			 	if (count($childcats) > 0 ) {
				echo '<nav class="menu clearfloat" id="nav-lower">
						<section class="clearfloat">
							<div class="menu-subcategories-container">
								<ul class="nav">';

								foreach ($childcats as $childcat) {
								  if (cat_is_ancestor_of($ancestor, $childcat->cat_ID) == false) {
								    if ( $title != $childcat->cat_name) {
								    	if ($pcat != $childcat->cat_ID) {
										    echo '<li><a href="'.get_category_link($cat).'/?cat='.$childcat->cat_ID.'">';
										    echo $childcat->cat_name . '</a>';
										    echo '</li>';
										    $ancestor = $childcat->cat_ID;
									    }
								    }

								  }
								}
								echo '</ul>
							</div>
					  </section>
					</nav>';
			    }
             }
        }?>


		<?php if ($title == 'Ask Tom') {

			echo '<nav class="menu clearfloat" id="nav-lower">
						<section class="clearfloat">
							<div class="menu-subcategories-container">
								<ul class="nav">';

								query_posts('category_name=ask-tom');
								if (have_posts()) : while (have_posts()) : the_post();
									$postcats = get_the_category();
									if ($postcats) {
										foreach($postcats as $category) {
											$all_cats_arr[] = $category->cat_ID;
										}
									}
								endwhile; endif;

							$cats_arr = array_unique($all_cats_arr); //REMOVES DUPLICATES
							//echo '<pre>'.print_r($cats_arr, true).'</pre>'; //OUTPUT FINAL TAGS FROM CATEGORY

							foreach ($cats_arr as $v) {
								if ($v != 'ask-tom') {
									$subCatId = $v->category_nicename;
                                    //echo '<pre>'.$v.'</pre>';
								    $result = str_replace("-", " ", $v);
								    $cleanResult  = str_replace("&", "", $result);
                                    //echo '<li><a href="'.get_category_link( $category_id ).'?cat='. $v . '">' . get_the_category_by_id($v) .'</a></li>';
                                    $tom_id = get_cat_ID( 'Ask Tom' );
								    if ( $v !== $tom_id) {

									    $category_link = get_category_link( $tom_id );
									    $catName = $_GET['cat'];
									    $queryCat = get_cat_ID( $catName );
                                        //echo '<pre>'.$category_id.'</pre>';

									    if (isset($catName)) {
                                            if ( $catName != $v ) {
                                                echo '<li><a href="'.get_category_link( $tom_id ).'?cat='. $v . '">' . get_the_category_by_id($v) .'</a></li>';
                                            }
										} else {
											echo '<li><a href="'.get_category_link( $tom_id ).'?cat='. $v . '">' . get_the_category_by_id($v) .'</a></li>';
										}
								    }
								}
							}
				echo '</ul>
					</div>
				</section>
			</nav>';?>
                <div class="">
                    <section class="tom full-width">
                    <?php
                    //950 live
                    //892 local
                    $askTomCatNum = 950;

                    $queryString = $_SERVER['QUERY_STRING'];
                    $queryCat = get_cat_ID( $queryString );
                    $catName = $_GET['cat'];

                    if (isset($catName)) {
                        //It exists
                        echo '<h2>texas'.$paged.$catName.'</h2>';
                        $the_query = new WP_Query(array('category__and'=>array($askTomCatNum,$catName)));

                        if ( in_category( 'ask-tom') ) {
                            while( $the_query->have_posts() ) {
                                $the_query->the_post();
                                get_template_part( 'content', 'ask-tom-archive' );

                            }
                            wp_reset_postdata();
                        }

                    } else {
                        //It Doensnt exists
                        $tom_query = new WP_Query();
                        $args = array(
                            'posts_per_page' => 10,
                            'category' => 950,
                            'paged' => $paged
                        );
                        $tom_query  = new WP_Query( $args );
                        //$tom_query->query('cat=950&posts_per_page='.get_option('posts_per_page').'&paged=' . $paged);

                        echo '<h2>'.$paged.'</h2>';
                        if ( in_category( 'ask-tom') ) {
                            while( $tom_query->have_posts() ) {
                                $tom_query->the_post();
                                get_template_part( 'content', 'ask-tom-archive' );

                            }
                            wp_reset_postdata();
                        }

                    }

                ?>
                    </section>
            </div>
           <?php } else { ?>
            <div class="masonry-wrapper">
                <section class="not-tom full-width">
                  <?php if (in_category( 'Ask Tom' )) { ?>
                        <article class="ask-tom-link">
                            <div class="excerpt-wrap">
                                <h2 class="posttitle">See <a href="category/ask-tom/?cat=<?php echo $cat; ?>" rel="bookmark"><?php echo $title; ?></a> Questions and Answers in Ask Tom</h2>
                            </div>
                            <div class="excerpt-wrap">
                                <h2 class="posttitle">See All<a href="category/ask-tom/"> Ask Tom</a> Questions and Answers</h2>
                            </div>
                        </article>
                        <?php wp_reset_postdata(); ?>
                    <?php
                    } ?>

                    <?php
                        $tom_query = new WP_Query();
                        $args = array(
                            'cat' => get_cat_ID( $title ),
                            'posts_per_page' => 10,
                            'category__not_in' => 950,
                            'paged' => $paged
                        );
                        $tom_query  = new WP_Query( $args );
                        while( $tom_query->have_posts() ) {
                            $tom_query->the_post();
                            get_template_part( 'content', 'archive' );

                        }
                        wp_reset_postdata();

                    ?>
                </section>
            </div>
        <?php }
            next_posts_link( 'Older Posts', $max_pages );
            previous_posts_link( 'Newer Posts' );


		} else {
?>
            <h2><?php _e( 'Not Found', 'opti' ); ?></h2>
<?php
		}

?>
	</div>
	<?php get_sidebar(); ?>
</section>
<script type="text/javascript">
/*
(function($){
        var article = $('.category-ask-tom .tom article');
		article.hide();

		$('.cat-show a').bind('click' , function (){
		  var href = $(this).attr('href');
		  var target = href.replace('#','');
		  console.log(target +'    '+'.category-ask-tom .tom article.'+target+'');
		  article.hide();
			 $('.category-ask-tom .tom article.'+target+'').each(function(){
				 $(this).show();
			 })

	});
	var URL = window.location;
	var pathArray = window.location.pathname.split( '/' );
	var newPathname = "";

	for (i = 0; i < pathArray.length-2; i++) {
    	newPathname += pathArray[i];
	    if (i != pathArray.length-2) {
	      newPathname += "/";
	    }
	}

	jQuery('#nav-lower.menu.simple a').attr('href',newPathname);

})(jQuery)
*/
</script>
<?php
	get_footer();