<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $person = new Person($db);

  // Get raw person data
  $data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->id)&&
    !empty($data->first_name)&&
    !empty($data->last_name)&&
    !empty($data->medicare)&&
    !empty($data->phone)&&
    !empty($data->address)&&
    !empty($data->city)&&
    !empty($data->province)&&
    !empty($data->postal_code)&&
    !empty($data->email)
){
  $person->id = $data->id;
  $person->first_name = $data->first_name;
  $person->last_name = $data->last_name;
  $person->dob = date('Y-m-d');
  $person->medicare = $data->medicare;
  $person->phone = $data->phone;
  $person->address = $data->address;
  $person->city = $data->city;
  $person->province = $data->province;
  $person->postal_code = $data->postal_code;
  $person->email = $data->email;

  // Create post
  if($person->create()) {
    echo json_encode(
      array('message' => 'Person Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Person Not Created')
    );
  }
}