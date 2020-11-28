<?php

class AdminOnlineMassesController {
  public static function list(){
    if($_GET['refresh'] == true){
      OnlineMass::fetch_all();
      redirect_prev_page();
    }

    $table = new Online_Masses_List_Table();
    $table->prepare_items();
    online_masses_views_admin_list($table);
  }
}
