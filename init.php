<?php
/*
Plugin Name: Custom List Table With Database Example
Description: A highly documented plugin that demonstrates how to create custom admin list-tables from database using WP_List_Table class.
Version:     1.0
Author:      Prashant Baldha
Author URI:  https://github.com/pmbaldha/
License:     GPL2
*/

/**
 * $online_masses_db_version - holds current database version
 * and used on plugin update to sync database tables
 */
global $wpdb;

$online_masses_api_name = 'online-masses';
$online_masses_db_version ='1.3';
$online_masses_table_name = $wpdb->prefix . 'online_masses';

require_once('db/migration.php');
require_once('db/seed.php');
require_once('helpers.php');

require_once('api/fetch_data.php');

require_once('models/online_mass.php');

require_once('admin-menu.php');
require_once('admin-list.php');
require_once('admin-create.php');
