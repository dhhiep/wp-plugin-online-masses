<?php
/**
 * Plugin Name: TGPSG Online Masses
 * Plugin URI: https://github.com/dhhiep/wp-plugin-online-masses
 * Description: TGPSG Online Masses is a solution to embedded online masses live stream from channel "TGPSG Thánh Lễ trực tuyến" automatically.
 * Version: 1.0
 * Author: Hiep Dinh
 * Author URI: https://github.com/dhhiep
 */

//  declare global variables
global $wpdb;

// Set timezone to Asia/Ho_Chi_Minh - +7:00
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Configurations
$online_masses_api_name = 'online-masses';
$online_masses_db_version ='1.0';
$online_masses_table_name = $wpdb->prefix . 'online_masses';

// Database utils
require_once('db/migration.php');

// Helpers
require_once('helpers/form.php');
require_once('helpers/navigation.php');
require_once('helpers/array.php');
require_once('helpers/time.php');

// APIs
require_once('api/fetch.php');

// Services
require_once('services/table/online_masses.php');

// Models
require_once('models/online_mass.php');

// Views
require_once('views/admin/menu.php');
require_once('views/admin/list.php');
require_once('views/admin/new.php');
require_once('views/admin/edit.php');
require_once('views/admin/show.php');

// WP Shortcodes
require_once('views/shortcodes/online_masses_streaming_or_upcoming.php');
require_once('views/shortcodes/online_masses_streamed.php');

// Controllers
require_once('controllers/admin/online_masses_controller.php');
