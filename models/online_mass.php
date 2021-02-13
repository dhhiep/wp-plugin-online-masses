<?php
class OnlineMass {
  // attributes
  public $timestamp;
  public $id;
  public $url;
  public $thumbnail;
  public $title;
  public $event_type;
  public $published_at;
  public $ended_at;
  public $allow_update = 1;
  public $is_deleted = 0;

  // CLASS METHODS FOR MODEL
  public static function table_name(){
    return $GLOBALS['online_masses_table_name'];
  }

  public static function db_connector(){
    return $GLOBALS['wpdb'];
  }

  // HELPER METHODS TO GET DATA

  public static function find_by_timestamp($timestamp) {
    $table_name = self::table_name();
    $item =
      self::db_connector()->get_row(
        self::db_connector()->prepare("
          SELECT *
          FROM $table_name
          WHERE timestamp = $timestamp
        "), ARRAY_A
      );

    if($item){
      return new self($item);
    }
  }

  public static function find_by_id($id) {
    $table_name = self::table_name();
    $item =
      self::db_connector()->get_row(
        self::db_connector()->prepare("
          SELECT *
          FROM $table_name
          WHERE id = '$id'
        "), ARRAY_A
      );

    if($item){
      return new self($item);
    }
  }

  public static function find_by_type($event_type, $order_by = 'DESC', $limit = 10) {
    $table_name = self::table_name();
    $items =
      self::db_connector()->get_results(
        self::db_connector()->prepare("
          SELECT *
          FROM $table_name
          WHERE event_type = '$event_type'
            AND is_deleted = 0
          ORDER BY timestamp $order_by
          LIMIT $limit
        "), ARRAY_A
      );

    $online_masses =
      array_map(function($item){
        return new self($item);
      }, $items);

    return $online_masses;
  }


  public static function find_by_time_range($strtotime, $order_by = 'DESC', $limit = 10) {
    $table_name = self::table_name();

    $timestamp = strtotime($strtotime);
    $beginning_of_day = beginning_of_day($timestamp);
    $end_of_day = end_of_day($timestamp);

    $items =
      self::db_connector()->get_results(
        self::db_connector()->prepare("
          SELECT *
          FROM $table_name
          WHERE timestamp >= $beginning_of_day
            AND timestamp <= $end_of_day
            AND is_deleted = 0
          ORDER BY timestamp $order_by
          LIMIT $limit
        "), ARRAY_A
      );

    $online_masses =
      array_map(function($item){
        return new self($item);
      }, $items);

    return $online_masses;
  }

  // METHODS FOR SPECIFY SCOPE

  public static function all($delete_status, $per_page, $paged) {
    $table_name = self::table_name();
    $items =
      self::db_connector()->get_results(
        self::db_connector()->prepare("
          SELECT *
          FROM $table_name
          WHERE is_deleted = $delete_status
          ORDER BY timestamp DESC
          LIMIT $per_page OFFSET $paged
        "), ARRAY_A
      );

    $online_masses =
      array_map(function($item){
        return new self($item);
      }, $items);

    return $online_masses;
  }

  public static function upcoming() {
    $upcoming_masses = OnlineMass::find_by_type('upcoming', 'ASC', 1);

    return $upcoming_masses[0];
  }

  public static function streamed($number_of_videos = 2) {
    $streamed_masses = OnlineMass::find_by_type('streamed', 'DESC', $number_of_videos);

    return $streamed_masses;
  }

  public static function mark_deleted($id, $flag = 1) {
    $online_mass = self::find_by_id($id);

    $mass = array(
      "id" => $id,
      "is_deleted" => $flag,
    );

    return $online_mass->update($mass);
  }

  public static function mark_streamed($id) {
    $online_mass = self::find_by_id($id);
    $mass_streamed = array(
      "id" => $id,
      "event_type" => "streamed",
      "ended_at" => strftime('%Y-%m-%d %T %z', time()),
      "allow_update" => 0,
    );

    return $online_mass->update($mass_streamed);
  }

  public static function mark_upcoming($id) {
    $online_mass = self::find_by_id($id);
    $mass_upcoming = array(
      "id" => $id,
      "event_type" => "upcoming",
      "ended_at" => 'NULL',
      "allow_update" => 0,
    );

    return $online_mass->update($mass_upcoming);
  }

  public static function create($mass) {
    $online_mass = new self();
    $mass_data = array_merge($online_mass->to_array(), array_compact($mass));

    self::db_connector()->insert(self::table_name(), $mass_data);
  }

  // FETCH DATA FROM ANALYTICS API
  public static function fetch_all() {
    $masses = file_get_contents('https://467f3zdo54.execute-api.ap-southeast-1.amazonaws.com/live/api/masses/');
    $masses = json_decode($masses, true);

    if (is_array($masses) || is_object($masses)){
      foreach ($masses as $mass) {
        // Don't update record has allow_update flag is false
        $existed_mass = self::find_by_id($mass['id']);
        if($existed_mass && $existed_mass->allow_update != 1){
          continue;
        }

        if($existed_mass){
          $existed_mass->update($mass);
        } else {
          self::create($mass);
        }
      }
    }
  }

  // Constructor
  function __construct($data = null) {
    if($data) {
      $this->timestamp = $data['timestamp'];
      $this->id = $data['id'];
      $this->url = $data['url'];
      $this->thumbnail = $data['thumbnail'];
      $this->title = $data['title'];
      $this->event_type = $data['event_type'];
      $this->published_at = $data['published_at'];
      $this->ended_at = $data['ended_at'];
      $this->allow_update = $data['allow_update'];
      $this->is_deleted = $data['is_deleted'];
    }
  }

  // Instance methods
  public function update($mass) {
    $mass_data = array_merge($this->to_array(), array_compact($mass));
    return self::db_connector()->update(self::table_name(), $mass_data, array('id' => $mass['id']));
  }

  public function delete($id){
    return self::db_connector()->delete(self::table_name(), array('id' => $id));
  }

  function to_array(){
    return array (
      'timestamp' => $this->timestamp,
      'id' => $this->id,
      'url' => $this->url,
      'thumbnail' => $this->thumbnail,
      'title' => $this->title,
      'event_type' => $this->event_type,
      'published_at' => $this->published_at,
      'ended_at' => $this->ended_at,
      'allow_update' => $this->allow_update,
      'is_deleted' => $this->is_deleted,
    );
  }
}
