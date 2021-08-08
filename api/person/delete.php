<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $person = new Person($db);
  
  // Get raw person data
  // $data = json_decode(file_get_contents("php://input"));

  //Set ID to update
  $person->p_id = $_GET['delete'];

  // delete post
  if($person->delete()) {
    Header("Location: read.php");
  } else {
    echo "<h1> Deletion Failed! </h1>";
    echo "<form>
    <input type='button' value='Back' onclick='history.go(-1)'>
    </form>";
  }