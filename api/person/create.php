<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
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
  // $data = json_decode(file_get_contents("php://input"));

  // $person->p_id = $data->p_id;
  $person->first_name = $_POST['first_name'];
  $person->last_name = $_POST['last_name'];
  $person->dob = $_POST['dob'];
  $person->phone = $_POST['phone'];
  $person->address = $_POST['address'];
  $person->city = $_POST['city'];
  $person->province = $_POST['province'];
  $person->postal_code = $_POST['postal_code'];
  $person->email = $_POST['email'];
  $person->citizenship = $_POST['citizenship'];

  // Create person
  if($person->create()) {
    header("Location: read.php");
  } else {
    echo "<form>
    <input type='button' value='Back' onclick='history.go(-1)'>
    </form>";
  }