<?php

/**
 * Simple function that validates data and retrieve bool on success
 * and error message(s) on error
 *
 * @param $item
 * @return bool|string
 */
function online_masses_validate_person($item)
{
    $messages = array();

    if (empty($item['name'])) $messages[] = __('Name is required', 'online_masses');
    if (!empty($item['email']) && !is_email($item['email'])) $messages[] = __('E-Mail is in wrong format', 'online_masses');
    if (!ctype_digit($item['age'])) $messages[] = __('Age in wrong format', 'online_masses');
    if (empty($messages)) return true;
    return implode('<br />', $messages);
}
