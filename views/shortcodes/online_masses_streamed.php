<?php
function online_masses_streamed(){
  $online_mass = OnlineMass::streamed();
  $iframe_video_yesterday = online_masses_iframe_builder($online_mass[0]->id);
  $iframe_video_last_2_day = online_masses_iframe_builder($online_mass[1]->id);
  return <<<HTML
    <div class="container mass-streamed">
      <div class="row row-large align-center">
        <div class="col small-12 medium-6 large-6 left">{$iframe_video_yesterday}</div>
        <div class="col small-12 medium-6 large-6 right">{$iframe_video_last_2_day}</div>
      </div>
    </div>
  HTML;
}

add_shortcode('online_masses_streamed', 'online_masses_streamed');
