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

  // Class Methods
  public static function table_name(){
    return $GLOBALS['online_masses_table_name'];
  }

  public static function db_connector(){
    return $GLOBALS['wpdb'];
  }

  public static function mark_deleted($timestamp, $flag = 1) {
    $online_mass = self::find_by('timestamp', $timestamp);

    // Mark deleted
    $mass = array(
      "timestamp" => $timestamp,
      "is_deleted" => $flag,
    );

    return $online_mass->update($mass);
  }

  public static function fetch_all() {
    // Fetch data from serverless API
    $masses = file_get_contents('https://467f3zdo54.execute-api.ap-southeast-1.amazonaws.com/live/api/masses/');
    $masses = json_decode($masses, true);

    if (is_array($masses) || is_object($masses)){
      foreach ($masses as $mass) {
        // Don't update record mark not editable
        $existed_mass = self::find_by('timestamp', $mass['timestamp']);
        if($existed_mass && $existed_mass->allow_update != 1){
          continue;
        }

        if($existed_mass){
          $existed_mass->update($mass);
        } else {
          $online_mass = new self();
          $online_mass->create($mass);
        }
      }
    }
  }

  public static function find_by($key, $value) {
    $table_name = self::table_name();
    $item =
      self::db_connector()->get_row(
        self::db_connector()->prepare("SELECT * FROM $table_name WHERE $key = %d", $value),
        ARRAY_A
      );

    if($item){
      return new self($item);
    }
  }

  // Constructor
  function __construct($data = null) {
    if($data) {
      $this->set_self($data);
    }
  }

  // Instance methods
  public function create($mass) {
    $mass_data = array_merge($this->to_array(), array_compact($mass));
    return self::db_connector()->insert(self::table_name(), $mass_data);
  }

  public function update($mass) {
    $mass_data = array_merge($this->to_array(), array_compact($mass));
    return self::db_connector()->update(self::table_name(), $mass_data, array('timestamp' => $mass['timestamp']));
  }

  public function delete($timestamp){
    return self::db_connector()->delete(self::table_name(), array('timestamp' => $timestamp));
  }

  function all_timestamps(){
    $table_name = self::table_name();
    $timestamps =
      self::db_connector()->get_results(
        self::db_connector()->prepare("SELECT timestamp FROM $table_name"),
        ARRAY_A
      );

    $timestamps =
      array_map(function($row){
        return $row['timestamp'];
      }, $timestamps);

    return $timestamps;
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

  // Private methods
  private function set_self($item){
    $this->timestamp = $item['timestamp'];
    $this->id = $item['id'];
    $this->url = $item['url'];
    $this->thumbnail = $item['thumbnail'];
    $this->title = $item['title'];
    $this->event_type = $item['event_type'];
    $this->published_at = $item['published_at'];
    $this->ended_at = $item['ended_at'];
    $this->allow_update = $item['allow_update'];
    $this->is_deleted = $item['is_deleted'];

    return $this;
  }
}
