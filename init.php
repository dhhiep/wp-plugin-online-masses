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

// Controllers
require_once('controllers/admin/online_masses_controller.php');

