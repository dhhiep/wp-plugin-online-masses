<?php

class AdminOnlineMassesController {
  public static function list(){
    if(array_key_exists('refresh', $_GET) && $_GET['refresh'] == true){
      OnlineMass::fetch_all();
      redirect_prev_page();
    }

    $table = new Online_Masses_List_Table();
    $table->prepare_items();
    online_masses_views_admin_list($table);
  }

  public static function deleted(){
    $table = new Online_Masses_List_Table();
    $table->prepare_items(1);
    online_masses_views_admin_list($table);
  }

  public static function delete(){
    if($_GET['id']){
      $delete_flag = 1;
      OnlineMass::mark_deleted($_GET['id'], $delete_flag);
      redirect_prev_page();
    }
  }

  public static function recovery(){
    if($_GET['id']){
      $recovery_flag = 0;
      OnlineMass::mark_deleted($_GET['id'], $recovery_flag);
      redirect_prev_page();
    }
  }

  public static function mark_streamed(){
    if($_GET['id']){
      OnlineMass::mark_streamed($_GET['id']);
      redirect_prev_page();
    }
  }

  public static function mark_upcoming(){
    if($_GET['id']){
      OnlineMass::mark_upcoming($_GET['id']);
      redirect_prev_page();
    }
  }
}
