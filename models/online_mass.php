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

  public static function findBy($key, $value) {
    $table_name = self::table_name();
    $item =
      self::db_connector()->get_row(
        self::db_connector()->prepare("SELECT * FROM $table_name WHERE $key = %d", $value),
        ARRAY_A
      );

    return new self($item);
  }

  // Constructor
  function __construct($data) {
    if($data){
      $this->set_self($data);
    }
  }

  // Instance methods
  public function create($mass) {
    self::db_connector()->insert(self::table_name(), array(
      "timestamp" => $mass["timestamp"],
      "id" => $mass["id"],
      "url" => $mass["url"],
      "thumbnail" => $mass["thumbnail"],
      "title" => $mass["title"],
      "event_type" => $mass["event_type"],
      "published_at" => $mass["published_at"],
    ));
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

    return $this;
  }
}
