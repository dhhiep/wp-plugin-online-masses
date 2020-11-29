<?php
function beginning_of_day($timestamp) {
  return strtotime("today", $timestamp);
}

function end_of_day($timestamp) {
  $begin_of_day = beginning_of_day($timestamp);

  return strtotime("tomorrow", $begin_of_day) - 1;
}