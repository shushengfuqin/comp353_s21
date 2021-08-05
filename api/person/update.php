<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $person = new Person($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  //Set ID to update
  $person->p_id = $data->p_id;
    
    $person->first_name = $data->first_name;
    $person->last_name = $data->last_name;
    $person->dob = $data->dob;
    $person->phone = $data->phone;
    $person->address = $data->address;
    $person->city = $data->city;
    $person->province = $data->province;
    $person->postal_code = $data->postal_code;
    $person->email = $data->email;
  
    // Update post
    if($person->update()) {
      echo json_encode(
        array('message' => 'Person Updated')
      );
    } else {
      echo json_encode(
        array('message' => 'Person Not Updated')
      );
    }