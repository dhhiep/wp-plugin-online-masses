<?php
function online_masses_views_admin_list($table) {
?>
  <div class="wrap">
    <h2>
      <!-- <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=online_masses_create');?>">Tạo mới</a> -->
      <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=online_masses&refresh=true');?>">Cập nhật</a>
    </h2>
    <form id="online-masses-table" method="GET">
      <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
      <?php $table->display() ?>
    </form>
  </div>
<?php
}
