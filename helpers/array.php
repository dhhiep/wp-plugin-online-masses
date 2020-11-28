<?php

function array_compact($arr){
  $new_array = array_filter($arr, function($element){
    return !is_null($element) && trim($element) != '';
  });

  return $new_array;
}