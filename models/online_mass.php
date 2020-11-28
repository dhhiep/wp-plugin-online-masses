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
  public $auto_update;

  // Class Methods
  public static function table_name(){
    return $GLOBALS['online_masses_table_name'];
  }

  public static function db_connector(){
    return $GLOBALS['wpdb'];
  }

  public static function create_mass($mass) {
    $online_mass = new self();

    return $online_mass->create($mass);
  }

  public static function update_mass($mass) {
    $online_mass = new self();

    return $online_mass->update($mass);
  }

  public static function delete_mass($timestamp) {
    $online_mass = new self();

    return $online_mass->delete($timestamp);
  }

  public static function fetch_all() {
    // Fetch data from serverless API
    $masses = file_get_contents('https://467f3zdo54.execute-api.ap-southeast-1.amazonaws.com/live/api/masses/');
    $masses = json_decode($masses, true);

    if (is_array($masses) || is_object($masses)){
      foreach ($masses as $mass) {
        // Don't update record mark not editable
        $existed_mass = self::findBy('timestamp', $mass['timestamp']);
        if($existed_mass && $existed_mass->auto_update != 1){
          continue;
        }

        if($existed_mass){
          self::update_mass($mass);
        } else {
          self::create_mass($mass);
        }
      }
    }
  }

  public static function findBy($key, $value) {
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
    return
      self::db_connector()->insert(self::table_name(), array(
        "timestamp" => $mass["timestamp"],
        "id" => $mass["id"],
        "url" => $mass["url"],
        "thumbnail" => $mass["thumbnail"],
        "title" => $mass["title"],
        "event_type" => $mass["event_type"],
        "event_type" => $mass["event_type"],
        "published_at" => $mass["published_at"],
        "ended_at" => $mass["ended_at"],
      ));
  }

  public function update($mass) {
    return
      self::db_connector()->update(self::table_name(), array(
        "timestamp" => $mass["timestamp"],
        "id" => $mass["id"],
        "url" => $mass["url"],
        "thumbnail" => $mass["thumbnail"],
        "title" => $mass["title"],
        "event_type" => $mass["event_type"],
        "published_at" => $mass["published_at"],
        "ended_at" => $mass["ended_at"],
      ), array('timestamp' => $mass['timestamp']));
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
    $this->auto_update = $item['auto_update'];

    return $this;
  }
}
