<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $person = new Person($db);

  // Get ID
  $person->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get person
  $person->readone();

  // Create array
  $person_arr = array(
    'id' => $person->id,
    'first name' => $person->first_name,
    'last name' => $person->last_name,
    'date of birth' => $person->dob,
    'phone' => $person->phone,
    'address' => $person->address,
    'city' => $person->city,
    'province' => $person->province,
    'postal_code' => $person->postal_code ,
    'email' => $person->email
  );

  // Make JSON
  print_r(json_encode($person_arr));