<?php
/**
 * PART 3. Admin page
 * ============================================================================
 *
 * In this part you are going to add admin page for custom table
 *
 * http://codex.wordpress.org/Administration_Menus
 */

/**
 * admin_menu hook implementation, will add pages to list persons and to add new one
 */
function online_masses_admin_menu()
{
    add_menu_page("Thánh Lễ Online", "Thánh Lễ Online", 'activate_plugins', 'online_masses', 'online_masses_page_handler');
    add_submenu_page('online_masses', "Tất cả các Thánh Lễ", "Tất cả", 'activate_plugins', 'online_masses', 'online_masses_page_handler');
    add_submenu_page('online_masses', "Tạo mới Thánh Lễ", "Tạo mới", 'activate_plugins', 'online_masses_create', 'online_masses_create_form_page_handler');
}

add_action('admin_menu', 'online_masses_admin_menu');
