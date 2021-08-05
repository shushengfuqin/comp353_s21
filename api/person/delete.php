<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
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

    //Set ID to update
    $person->id = $data->id;

      // delete post
  if($person->delete()) {
    echo json_encode(
      array('message' => 'Person Deleted')
    );
  } else {
    echo json_encode(
      array('message' => 'Person Not Deleted')
    );
  }