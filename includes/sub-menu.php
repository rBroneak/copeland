<!-- SHOW SUBCAT MENUE -->
<?php

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
			</nav>';
} ?>