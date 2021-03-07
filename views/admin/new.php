<?php

function online_masses_create_form_page_handler() {
  if($_POST['video_id']){
    $mass = OnlineMass::fetch($_POST['video_id']);
    do_action( 'qm/debug', $mass);
  }
?>

<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2>
      <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=online_masses');?>">
        <?php _e('Xem tất cả Thánh Lễ', 'online_masses')?>
      </a>
    </h2>

    <?php if (!empty($notice)): ?>
    <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
    <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

    <form id="form" method="POST">
      <div class="metabox-holder" id="poststuff">
        <div id="post-body">
          <div id="post-body-content">
            <div id="normal-sortables" class="meta-box-sortables">
              <div id="online_masses_form_meta_box" class="postbox ">
                <div class="postbox-header">
                  <h2 class="hndle">Thêm mới Thánh Lễ</h2>
                  <div class="handle-actions hide-if-no-js"><button type="button" class="handle-order-higher" aria-disabled="false" aria-describedby="online_masses_form_meta_box-handle-order-higher-description"><span class="screen-reader-text">Di chuyển lên</span><span class="order-higher-indicator" aria-hidden="true"></span></button><span class="hidden" id="online_masses_form_meta_box-handle-order-higher-description">Move Online mass data box up</span><button type="button" class="handle-order-lower" aria-disabled="false" aria-describedby="online_masses_form_meta_box-handle-order-lower-description"><span class="screen-reader-text">Di chuyển xuống</span><span class="order-lower-indicator" aria-hidden="true"></span></button><span class="hidden" id="online_masses_form_meta_box-handle-order-lower-description">Move Online mass data box down</span><button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Chuyển đổi bảng điều khiển: Online mass data</span><span class="toggle-indicator" aria-hidden="true"></span></button></div>
                </div>
                <div class="inside">
                  <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
                    <tbody>
                      <tr class="form-field">
                        <th valign="top" scope="row">
                          <label for="name">Youtube Video ID</label>
                        </th>
                        <td>
                          <input id="video_id" name="video_id" type="text" style="width: 95%" value="" size="50" class="code" placeholder="Nhập Youtube Video ID" required="">
                          <br>
                          <? if(isset($mass) && !$mass['timestamp']) { ?>
                            <em style="color: red">Youtube Video https://www.youtube.com/watch?v=<? echo $_POST['video_id'] ?> không hợp lệ!</em><br>
                          <? } ?>
                          <br>
                          <i>Cách lấy Yotube Video ID: </i><br>
                          <em>Ví dụ 1: Youtule URL https://www.youtube.com/watch?v=Ts2p5eKcrkU, Video ID sẽ <strong>Ts2p5eKcrkU</strong></em> <br>
                          <em>Ví dụ 2: Youtule URL https://www.youtube.com/watch?v=Ts2p5eKcrkU&feature=emb_title, Video ID sẽ <strong>Ts2p5eKcrkU</strong></em>
                        </td>
                      </tr>
                      <tr class="form-field">
                        <th valign="top" scope="row">
                          <label for="name"></label>
                        </th>
                        <td>
                          <input type="submit" class="add-new-h2" value="Thêm mới">
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <? if(isset($mass) && $mass['timestamp']) { ?>
                    <hr>
                    <h3 style="color: green;">Thêm thành công <?php echo $mass['title'] ?></h3>
                    <table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
                      <tbody>
                        <tr class="form-field">
                          <th valign="top" scope="row">
                            <label for="name">Tiêu đề</label>
                          </th>
                          <td>
                            <?php echo $mass['title'] ?>
                          </td>
                        </tr>
                        <tr class="form-field">
                          <th valign="top" scope="row">
                            <label for="name">Youtube URL</label>
                          </th>
                          <td>
                            <a href="<?php echo $mass['url'] ?>"><?php echo $mass['url'] ?></a>
                          </td>
                        </tr>
                        <tr class="form-field">
                          <th valign="top" scope="row">
                            <label for="name">Thumbnail</label>
                          </th>
                          <td>
                            <img src="<?php echo $mass['thumbnail'] ?>" alt="" width="300">
                          </td>
                        </tr>
                        <tr class="form-field">
                          <th valign="top" scope="row">
                            <label for="name">Thời gian phát:</label>
                          </th>
                          <td>
                            <?php echo $mass['published_at'] ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  <? } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
<?php
}
