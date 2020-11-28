<?php
$secret_key = 'GprVt89Qh2E47V33';

function online_masses_api_db_fetcher(WP_REST_Request $request ){
  global $secret_key;

  $params = $request->get_params();
  if ($params['token'] != $secret_key) {
    return response_message_builder(401, "Invalid token!");
  }

  OnlineMass::fetch_all();
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