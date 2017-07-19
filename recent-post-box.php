<?php
/*
Plugin Name: Recent Post Box
Author: Joe Jalbert
Description: Adds a 'recent post' box to the bottom of every article, showing the most recent story from the site
*/
 ?>
<?php
function add_post_box($content) {
  if (is_single()){
    wp_register_style( 'post_box', plugins_url('recent-post-box/style.css') );
    wp_enqueue_style( 'post_box');

    $latest = wp_get_recent_posts(array('numberposts' => '1'))[0];
    $latest_ID = $latest["ID"];
    $category = get_the_category($latest_ID)[0]->name;
    $cat_ID = get_the_category($latest_ID)[0]->cat_ID;
    $cat_link = get_category_link($cat_ID);
    $post_time = get_post_time('U', false, $latest_ID, false);
    $author_id = $latest["post_author"];
    $author_link = get_author_posts_url($author_id);
    $author_name = get_the_author_meta("first_name",$author_id) . ' ' . get_the_author_meta("last_name",$author_id);
    $thumb = get_the_post_thumbnail($latest_ID, "medium");
    $time_ago = human_time_diff($post_time, current_time('U')) . " ago";
    $latest_link = get_post_permalink($latest_ID);

    $content .= '
      <div class="post-box">
        <div class="thumb"><a href=' . $latest_link . '>' . $thumb . '</a></div>
        <div class="post-info">
          <h2 class="category"><a href=' . $cat_link . '>' . $category . '</a><span class="mobile-time"> | ' . $time_ago . '</span></h2>
          <div class="headline"><a href=' . $latest_link . '>' . $latest["post_title"] . '</a></div>
          <div class="desktop-info">By <span class="author"><a href=' . $author_link . '>' . $author_name . '</a></span> ' . $time_ago . '</div>
        </div>
      </div>
    ';
  }
  return $content;
}

add_filter( 'the_content', 'add_post_box', 0 );

function remove_empty_p_tags($content) {
  $content .= '<script>
              jQuery(document).ready(function(){
                jQuery(".post-box p:empty").remove();
              });
              </script>';
  return $content;
}
add_filter( 'the_content', 'remove_empty_p_tags', 0 );
