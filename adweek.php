<?php
/*
Plugin Name: Recent Post Box
Author: Joe Jalbert
Description: Adds a 'recent post' box to the bottom of every article, showing the newest story from the site
*/
 ?>
<?php
function add_my_stuff($content){
  if (is_single()){
    $content .= "aside>
      <div class='thumb'>
        <img src='image.png'></img>
      </div>
      <h2 class='category'><a>ADFREAK</a></h2>
      <div class='title'>Toyota's Very Strange New Cinema Ads Will Have Moviegoers Doign a Double-Take</div>
      <div class='info'>By David Gianatasio 12 Minutes ago</div>";
  }
  return $content;
}

add_filter ('the_content', 'add_my_stuff', 0);

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
