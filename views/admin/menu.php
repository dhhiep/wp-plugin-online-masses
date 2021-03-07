<?php
function online_masses_admin_menu()
{
  add_menu_page("Thánh Lễ Online", "Thánh Lễ Online", 'activate_plugins', 'online_masses', 'AdminOnlineMassesController::list');
  add_submenu_page('online_masses', "Tất cả các Thánh Lễ", "Tất cả", 'activate_plugins', 'online_masses', 'AdminOnlineMassesController::list');
  add_submenu_page('online_masses', "Tạo mới Thánh Lễ", "Thêm mới", 'activate_plugins', 'online_masses_create', 'online_masses_create_form_page_handler');
  add_submenu_page('online_masses', "Thánh lễ đã xoá", "Đã xoá", 'activate_plugins', 'online_masses_deleted', 'AdminOnlineMassesController::deleted');

  // Hide on UI
  add_submenu_page(null, "Delete a Online Mass", 'Delete Item', 'activate_plugins', 'online_masses_delete', 'AdminOnlineMassesController::delete');
  add_submenu_page(null, "Recovery a Online Mass", 'Recovery Item', 'activate_plugins', 'online_masses_recovery', 'AdminOnlineMassesController::recovery');
  add_submenu_page(null, "Mark Online Mass is Upcoming", 'mark_upcoming', 'activate_plugins', 'online_masses_mark_upcoming', 'AdminOnlineMassesController::mark_upcoming');
  add_submenu_page(null, "Mark Online Mass is Streamed", 'mark_streamed', 'activate_plugins', 'online_masses_mark_streamed', 'AdminOnlineMassesController::mark_streamed');
}

add_action('admin_menu', 'online_masses_admin_menu');
