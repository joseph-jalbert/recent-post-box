<?php
/*
Plugin Name: Recent Post Box
Author: Joe Jalbert
Description: Adds a 'recent post' box to the bottom of every article, showing the newest story from the site
*/
 ?>
<?php
function add_post_box($content){
  if (is_single()){

    $latest = wp_get_recent_posts(array('numberposts' => '1'))[0];
    $latestID = $latest["ID"];
    $category = get_the_category($latestID)[0]->name;
    $post_time = get_post_time('U', false, $latestID, false);
    $author_id = $latest["post_author"];
    $author_name = get_the_author_meta("first_name",$author_id) . ' ' . get_the_author_meta("last_name",$author_id);
    $thumb = get_the_post_thumbnail($latestID);
    $time_ago = human_time_diff($post_time, current_time('U')) . " ago";

    $content .= "
      <aside>
        <div class='thumb'>
          <img src='image.png'>$thumb</img>
        </div>
        <h2 class='category'><a>$category</a><div class='mobileTime'>| $time_ago</div></h2>
        <div class='title'>" . $latest["post_title"] . "</div>
        <div class='info'>By $author_name $time_ago</div>
      </aside>
    ";
  }
  return $content;
}

add_filter ('the_content', 'add_post_box', 0);

 ?>

<!-- <link rel="stylesheet" type="text/css" href="style.css">
<aside>
  <div class='thumb'>
    <img src='image.png'></img>
  </div>
  <h2 class='category'><a>ADFREAK</a></h2>
  <div class='title'>Toyota's Very Strange New Cinema Ads Will Have Moviegoers Doign a Double-Take</div>
  <div class='info'>By David Gianatasio 12 Minutes ago</div>
</aside> -->
