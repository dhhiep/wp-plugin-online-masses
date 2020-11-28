<?php
function online_masses_admin_menu()
{
  add_menu_page("Thánh Lễ Online", "Thánh Lễ Online", 'activate_plugins', 'online_masses', 'AdminOnlineMassesController::list');
  add_submenu_page('online_masses', "Tất cả các Thánh Lễ", "Tất cả", 'activate_plugins', 'online_masses', 'AdminOnlineMassesController::list');
  add_submenu_page('online_masses', "Tạo mới Thánh Lễ", "Tạo mới", 'activate_plugins', 'online_masses_create', 'online_masses_create_form_page_handler');
}

add_action('admin_menu', 'online_masses_admin_menu');
