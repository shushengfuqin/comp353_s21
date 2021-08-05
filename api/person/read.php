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

  // Blog person query
  $result = $person->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any persons
  if($num > 0) {
    // Person array
    $persons_arr = array();
    // $persons_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $person_item = array(
        'id' => $id,
        'first name' => $first_name,
        'last name' => $last_name,
        'date of birth' => $dob,
        'medicare' => $medicare,
        'phone' => $phone,
        'address' => $address,
        'city' => $city,
        'province' => $province,
        'postal code' => $postal_code,
        'E-Mail' => $email
      );

      // Push to "data"
      array_push($persons_arr, $person_item);
      // array_push($persons_arr['data'], $person_item);
    }

    // Turn to JSON & output
    echo json_encode($persons_arr);
  

  } else {
    // No Persons
    echo json_encode(
      array('message' => 'No Persons Found')
    );
  }
