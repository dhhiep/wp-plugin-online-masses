<?php
function online_masses_streamed(){
  $number_of_videos = 6;
  $online_masses = OnlineMass::streamed($number_of_videos);

  $video_blocks = [];
  foreach ($online_masses as $online_mass) {
    $iframe_video = online_masses_iframe_builder($online_mass->id);
    $video_block = <<<HTML
      <div class="col small-12 medium-6 large-6">{$iframe_video}</div>
    HTML;

    array_push($video_blocks, $video_block);
  }

  // Join array to html string
  $video_blocks = implode('', $video_blocks);

  return <<<HTML
    <div class="container mass-streamed">
      <div class="row row-large align-center">
        {$video_blocks}
      </div>
    </div>
  HTML;
}

add_shortcode('online_masses_streamed', 'online_masses_streamed');
