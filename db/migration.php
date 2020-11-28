<?php
/**
 * register_activation_hook implementation
 *
 * will be called when user activates plugin first time
 * must create needed database tables
 */
function online_masses_install()
{
    global $wpdb;
    global $online_masses_db_version;

    $table_name = $wpdb->prefix . 'online_masses';

    // sql to create your table
    $sql = "CREATE TABLE " . $table_name . " (
      timestamp INT(11) NOT NULL,
      id TINYTEXT NOT NULL,
      url TINYTEXT NOT NULL,
      thumbnail TINYTEXT NOT NULL,
      title TINYTEXT NOT NULL,
      event_type TINYTEXT NOT NULL,
      published_at TINYTEXT NOT NULL,
      ended_at TINYTEXT,
      auto_update TINYINT DEFAULT 1,
      is_deleted TINYINT DEFAULT 0,
      PRIMARY KEY (timestamp)
    );";

    // we do not execute sql directly
    // we are calling dbDelta which cant migrate database
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    // save current database version for later use (on upgrade)
    add_option('online_masses_db_version', $online_masses_db_version);

    /**
     * [OPTIONAL] Example of updating to 1.1 version
     *
     * If you develop new version of plugin
     * just increment $online_masses_db_version variable
     * and add following block of code
     *
     * must be repeated for each new version
     * in version 1.1 we change email field
     * to contain 200 chars rather 100 in version 1.0
     * and again we are not executing sql
     * we are using dbDelta to migrate table changes
     */
    $installed_ver = get_option('online_masses_db_version');
    if ($installed_ver != $online_masses_db_version) {
      $sql = "CREATE TABLE " . $table_name . " (
        timestamp INT(11) NOT NULL,
        id TINYTEXT NOT NULL,
        url TINYTEXT NOT NULL,
        thumbnail TINYTEXT NOT NULL,
        title TINYTEXT NOT NULL,
        event_type TINYTEXT NOT NULL,
        published_at TINYTEXT NOT NULL,
        ended_at TINYTEXT,
        auto_update TINYINT DEFAULT 1,
        is_deleted TINYINT DEFAULT 0,
        PRIMARY KEY (timestamp)
      );";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);

      // notice that we are updating option, rather than adding it
      update_option('online_masses_db_version', $online_masses_db_version);
    }
}

register_activation_hook(__FILE__, 'online_masses_install');

/**
 * Trick to update plugin database, see docs
 */
function online_masses_update_db_check()
{
    global $online_masses_db_version;
    if (get_site_option('online_masses_db_version') != $online_masses_db_version) {
        online_masses_install();
    }
}

add_action('plugins_loaded', 'online_masses_update_db_check');