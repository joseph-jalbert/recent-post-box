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
    wp_register_style( 'post_box', plugins_url('adweek/style.css') );
    wp_enqueue_style( 'post_box');

    $latest = wp_get_recent_posts(array('numberposts' => '1'))[0];
    $latestID = $latest["ID"];
    $category = get_the_category($latestID)[0]->name;
    $catID = get_the_category($latestID)[0]->cat_ID;
    $catLink = get_category_link($catID);
    $post_time = get_post_time('U', false, $latestID, false);
    $author_id = $latest["post_author"];
    $authorLink = get_author_posts_url($author_id);
    $author_name = get_the_author_meta("first_name",$author_id) . ' ' . get_the_author_meta("last_name",$author_id);
    $thumb = get_the_post_thumbnail($latestID, "medium");
    $time_ago = human_time_diff($post_time, current_time('U')) . " ago";
    $latestLink = get_post_permalink($latestID);


    $content .= '
      <div class="post-box">
        <div class="thumb"><a href=' . $latestLink . '>' . $thumb . '</a></div>
        <div class="post-info">
          <h2 class="category"><a href=' . $catLink . '>' . $category . '</a><span class="mobile-time"> | ' . $time_ago . '</span></h2>
          <div class="headline"><a href=' . $latestLink . '>' . $latest["post_title"] . '</a></div>
          <div class="desktop-info">By <span class="author"><a href=' . $authorLink . '>' . $author_name . '</a></span> ' . $time_ago . '</div>
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
