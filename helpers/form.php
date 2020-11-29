<?php

function online_masses_iframe_builder($video_id){
	return '<iframe
		src="https://www.youtube.com/embed/' . $video_id . '"
		frameborder="0"
		allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
		allowfullscreen>
	</iframe>';
}

function online_masses_validate_person($item) {
	$messages = array();

	if (empty($item['name'])) $messages[] = __('Name is required', 'online_masses');
	if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'online_masses');
	if (!ctype_digit($item['age'])) $messages[] = __('Age in wrong format', 'online_masses');
	if (empty($messages)) return true;
	return implode('<br />', $messages);
}

