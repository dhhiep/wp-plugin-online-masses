<?php
function om_beginning_of_day($timestamp) {
  return strtotime("today", $timestamp);
}

function om_end_of_day($timestamp) {
  $begin_of_day = om_beginning_of_day($timestamp);

  return strtotime("tomorrow", $begin_of_day) - 1;
}