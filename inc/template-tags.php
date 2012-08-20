<?php
/* *
 * Similar to ydn_get_top_level_cat, but gets WEEKEND subcategory 
 */
if (! function_exists("weekend_get_cat") ):
  function weekend_get_cat($post) {
    $print_cat = get_category_by_slug("print");
    $blog_cat = get_category_by_slug("blog");
    $cats = wp_get_post_categories( $post->ID, array("fields" => "all"));
    foreach ($cats as $cat) {
      if ( $cat->parent == $print_cat->cat_ID ) {
         return $cat->name;
      } else if ( $cat->term_taxonomy_id == $blog_cat->cat_ID ) {
        return $blog_cat->name;
      }
    }
    return null;
  }
endif;

/* *
 * Renders a WEEKEND block for the given post. Allows passing of classes
 */
if (! function_exists("weekend_render_block") ):
  function weekend_render_block($post_in, $size) {
    global $post;
    $temp_post = $post;
    $post = $post_in;

    $visual = get_the_post_thumbnail($post->ID,'weekend-'.$size);
    if ( empty($visual) ) {
      $visual = '<div class="no-image"></div>';
    }


    $visual = '<a href="' . get_permalink($post->ID) . '">'. $visual . '</a>';
?>
        <div class="block pop-out <?php echo $size; ?>">
          <div class="wrapper">
            <div class="right edge"><div></div></div>
            <div class="bottom edge"><div></div></div>
            <div class="content">
              <article id="post-<?php the_ID(); ?>" <?php echo post_class(); ?>>
                <div class="entry-image"><?php echo $visual; ?></div>     
                <div class="entry-meta">
                  <div class="cat-author"><span class="entry-category"><?php echo weekend_get_cat($post); ?></span> // <span class="entry-authors"><?php coauthors_posts_links(); ?></span></div>
                  <h3 class="entry-title"><a href="<?php echo the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
              </article>
            </div>
          </div>
        </div>
<?php
  $post = $temp_post;
  }
endif;


?>
