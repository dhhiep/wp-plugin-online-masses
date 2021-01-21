<?php
function online_masses_fetch_all() {
  global $post;

  if($post->post_name == "thanh-le-online"){
    OnlineMass::fetch_all();
  }
}

add_action('wp', 'online_masses_fetch_all', 10, 1);
