<?php

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class Online_Masses_List_Table extends WP_List_Table {
  function __construct()
  {
    global $status, $page;
    parent::__construct(array(
      'singular' => 'online-mass',
      'plural' => 'online-masses',
    ));
  }

  // Render columns default and specified columns
  function column_default($item, $column_name) {
    return '<a target="_blank" href="'. $item['url'] .'">'. $item[$column_name] .'</a>';
  }

  function column_thumbnail($item) {
    return '<a target="_blank" href="'. $item['url'] .'"><img src="'. $item['thumbnail'] .'" style="width: 200px; max-width: 100%;" alt=""></a>';
  }

  function column_event_type($item) {
    return ucfirst($item['event_type']);
  }

  function column_ended_at($item) {
    return $item['ended_at'] ? $item['ended_at'] : "Stream isn't start yet!";
  }

  function column_actions($item) {
    $actions = array(
      // 'edit' => sprintf('<a href="?page=online_masses_form&id=%s">%s</a>', $item['id'], 'Edit'),
    );

    if($item['is_deleted'] ==  1){
      $actions['recovery'] = sprintf('<a onclick="return confirm(\'Bạn có chắc là muốn khôi phục Thánh Lễ này không?\')" href="?page=online_masses_recovery&id=%s">%s</a>', $item['id'], 'Recovery');
    } else {
      $actions['delete'] = sprintf('<a onclick="return confirm(\'Bạn có chắc là muốn xoá Thánh Lễ này không?\')" href="?page=online_masses_delete&id=%s">%s</a>', $item['id'], 'Delete');
    }

    return sprintf('%s', $this->row_actions($actions));  }

  function get_columns() {
    $display_columns = array(
      'thumbnail' => '',
      'title' => 'Title',
      'id' => 'Video ID',
      'event_type' => 'Status',
      'published_at' => 'Started At',
      'ended_at' => 'Ended At',
      'actions' => '',
    );
    return $display_columns;
  }

  function prepare_items($delete_status = 0) {
    global $wpdb;
    global $online_masses_table_name;

    // Table config
    $per_page = 25;
    $display_columns = $this->get_columns();
    $hidden = array();
    $sortable = array();

    // here we configure table headers, defined in our methods
    $this->_column_headers = array($display_columns, $hidden, $sortable);

    // will be used in pagination settings
    $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $online_masses_table_name");

    // prepare query params, as usual current page, order by and order direction
    $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;

    $online_masses = OnlineMass::all($delete_status, $per_page, $paged);
    $this->items =
      array_map(function($mass) {
        return $mass->to_array();
      }, $online_masses);

    // Configure pagination
    $this->set_pagination_args(array(
      'total_items' => $total_items, // total items defined above
      'per_page' => $per_page, // per page constant defined at top of method
      'total_pages' => ceil($total_items / $per_page) // calculate pages count
    ));
  }
}
