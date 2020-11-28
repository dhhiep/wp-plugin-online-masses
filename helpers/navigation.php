<?php

function redirect_prev_page() {
  $prev_page = $_SERVER['HTTP_REFERER'];
  wp_safe_redirect($prev_page);
  exit();
}