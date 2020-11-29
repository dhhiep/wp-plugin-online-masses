<?php
function online_masses_streaming_or_upcoming(){
  $online_mass = OnlineMass::upcoming();
  $iframe_video = online_masses_iframe_builder($online_mass->id);
  return <<<HTML
    <div class="container mass-upcomming">
      {$iframe_video}
      <div class="title">{$online_mass->title}</div>
    </div>
  HTML;
}

add_shortcode('online_masses_streaming_or_upcoming', 'online_masses_streaming_or_upcoming');