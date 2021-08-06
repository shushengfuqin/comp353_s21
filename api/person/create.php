<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $person = new Person($db);

  // Get raw person data
  $data = json_decode(file_get_contents("php://input"));

  $person->p_id = $data->p_id;
  $person->first_name = $data->first_name;
  $person->last_name = $data->last_name;
  $person->phone = $data->phone;
  $person->address = $data->address;
  $person->city = $data->city;
  $person->province = $data->province;
  $person->postal_code = $data->postal_code;
  $person->email = $data->email;

  // Create person
  if($person->create()) {
    echo json_encode(
      array('message' => 'Post Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Post Not Created')
    );
  }