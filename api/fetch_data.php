<?php
$secret_key = 'GprVt89Qh2E47V33';

/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,  * or null if none.
 */

function online_masses_api_db_fetcher( WP_REST_Request $request ){
  global $secret_key;
  global $wpdb;

  $params = $request->get_params();
  $table_name = $wpdb->prefix . 'online_masses';

  if ($params['token'] != $secret_key) {
    return response_message_builder(401, "Invalid token!");
  }

  // Fetch data from serverless API
  // $masses = file_get_contents('https://467f3zdo54.execute-api.ap-southeast-1.amazonaws.com/live/api/masses/');
  // $masses = json_decode($masses, true);

  // if (is_array($masses) || is_object($masses)){
  //   foreach ($masses as $mass) {
  //     OnlineMass::create_mass($mass);
  //   }
  // }

  // print_r(gettype($masses));
  $online_mass = OnlineMass::findBy('timestamp', 1606818600);
  print_r($online_mass);
}

add_action( 'rest_api_init', function () {
  global $online_masses_api_name;

  register_rest_route( $online_masses_api_name . '/v1', '/fetch', array(
    'methods' => 'GET',
    'callback' => 'online_masses_api_db_fetcher',
  ));
});

function response_message_builder($http_code, $message){
  $data = array("message" => $message);

  return response_builder($http_code, $data);
}

function response_builder($http_code, $data){
  $response = new WP_REST_Response($data);
  $response->set_status($http_code);

  return $response;
}