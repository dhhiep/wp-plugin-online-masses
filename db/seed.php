<?php
/**
 * register_activation_hook implementation
 *
 * [OPTIONAL]
 * additional implementation of register_activation_hook
 * to insert some dummy data
 */
function online_masses_install_data() {
  global $wpdb;

  $current = date_create();
  $timestamp = date_timestamp_get($current);
  $table_name = $wpdb->prefix . 'online_masses'; // do not forget about tables prefix

  // mysql_query("SET NAMES utf8");
  $wpdb->insert($table_name, array(
    "timestamp" => $timestamp,
    "id" => "CuoSeb3X6Tg",
    "url" => "https://www.youtube.com/watch?v=CuoSeb3X6Tg",
    "thumbnail" => "https://i.ytimg.com/vi/CuoSeb3X6Tg/hqdefault_live.jpg",
    "title" => "Thánh Lễ trực tuyến ngày 30-11-2020: Kính thánh Anrê Tông đồ lúc 17:30",
    "event_type" => "upcoming",
    "published_at" => "2020-11-30 17:30:00 +0700"
  ));

  // $item = $wpdb->get_row($wpdb->prepare("SELECT timestamp FROM $table_name"), ARRAY_A);
}

// online_masses_install_data();