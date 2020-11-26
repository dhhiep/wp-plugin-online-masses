<?php
/**
 * Admin > Thanh Le Online > Tất Cả
 */

if (!class_exists('WP_List_Table')) {
  require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
* Online_Masses_List_Table class that will display our custom table
* records in nice table
*/
class Online_Masses_List_Table extends WP_List_Table {
  /**
   * [REQUIRED] You must declare constructor and give some basic params
   */
  function __construct()
  {
    global $status, $page;
    parent::__construct(array(
      'singular' => 'online-mass',
      'plural' => 'online-masses',
    ));
  }

  /**
   * [REQUIRED] this is a default column renderer
   *
   * @param $item - row (key, value array)
   * @param $column_name - string (key)
   * @return HTML
   */
  function column_default($item, $column_name)
  {
    return '<a target="_blank" href="'. $item['url'] .'">'. $item[$column_name] .'</a>';
  }

  /**
   * [OPTIONAL] this is example, how to render specific column
   *
   * method name must be like this: "column_[column_name]"
   *
   * @param $item - row (key, value array)
   * @return HTML
   */


  function column_actions($item) {
    $actions = array(
      'edit' => sprintf('<a href="?page=online-masses_form&id=%s">%s</a>', $item['timestamp'], __('Edit', 'online_masses')),
      'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['timestamp'], __('Delete', 'online_masses')),
    );

    return sprintf('%s', $this->row_actions($actions));
  }

  function column_thumbnail($item) {
    return '<a target="_blank" href="'. $item['url'] .'"><img src="'. $item['thumbnail'] .'" style="width: 200px; max-width: 100%;" alt=""></a>';
  }

  function column_timestamp($item)
  {
    return strftime("%d/%m/%Y %H:%M:%S", $item['timestamp']);
  }


  /**
   * [REQUIRED] This method return columns to display in table
   * you can skip columns that you do not want to show
   * like content, or description
   *
   * @return array
   */
  function get_columns() {
    $columns = array(
      'thumbnail' => '',
      'title' => 'Title',
      'id' => 'Video ID',
      'timestamp' => 'Published At',
      'actions' => '',
    );
    return $columns;
  }

  /**
   * [OPTIONAL] This method return columns that may be used to sort table
   * all strings in array - is column names
   * notice that true on name column means that its default sort
   *
   * @return array
   */
  function get_sortable_columns()
  {
    $sortable_columns = array(
      'timestamp' => array('timestamp', false),
      'thumbnail' => array('thumbnail', false),
      'id' => array('id', false),
      'title' => array('title', false),
      'url' => array('url', false),
    );

    return $sortable_columns;
  }

  /**
   * [REQUIRED] This is the most important method
   *
   * It will get rows from database and prepare them to be showed in table
   */
  function prepare_items()
  {
      global $wpdb;


      // $table_name = $wpdb->prefix . 'cte'; // do not forget about tables prefix
      $table_name = $wpdb->prefix . 'online_masses';

      $per_page = 25; // constant, how much records will be shown per page

      $columns = $this->get_columns();
      $hidden = array();
      $sortable = $this->get_sortable_columns();

      // here we configure table headers, defined in our methods
      $this->_column_headers = array($columns, $hidden, $sortable);

      // will be used in pagination settings
      $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

      // prepare query params, as usual current page, order by and order direction
      $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] - 1) * $per_page) : 0;
      $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'timestamp';
      $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

      // [REQUIRED] define $items array
      // notice that last argument is ARRAY_A, so we will retrieve array
      $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

      // [REQUIRED] configure pagination
      $this->set_pagination_args(array(
          'total_items' => $total_items, // total items defined above
          'per_page' => $per_page, // per page constant defined at top of method
          'total_pages' => ceil($total_items / $per_page) // calculate pages count
      ));
  }
}


/**
 * List page handler
 *
 * This function renders our custom table
 * Notice how we display message about successfull deletion
 * Actualy this is very easy, and you can add as many features
 * as you want.
 *
 * Look into /wp-admin/includes/class-wp-*-list-table.php for examples
 */
function online_masses_page_handler()
{
  global $wpdb;

  $table = new Online_Masses_List_Table();
  $table->prepare_items();

  $message = '';
  if ('delete' === $table->current_action()) {
    $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'online_masses'), count($_REQUEST['id'])) . '</p></div>';
  }
  ?>
  <div class="wrap">
    <h2>
      <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=online_masses_create');?>">Tạo mới</a>
      <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=online_masses_create');?>">Cập nhật</a>
    </h2>
    <?php echo $message; ?>
    <form id="online-masses-table" method="GET">
      <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
      <?php $table->display() ?>
    </form>
  </div>
<?php
}
