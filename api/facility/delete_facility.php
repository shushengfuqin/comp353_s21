<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  // header('Access-Control-Allow-Methods: GET');
  // header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Facility.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $facility = new Facility($db);
  
  // Get raw person data
  // $data = json_decode(file_get_contents("php://input"));

  //Set ID to update
  $facility->loc_id = $_GET['delete'];

  // delete post
  if($facility->delete()) {
    // Header("Location: read.php");
    echo '<script type="text/javascript">
           window.location = "read_facility.php"
      </script>';
  } else {
    echo "<h1> Deletion Failed! </h1>";
    echo "<form>
    <input type='button' value='Back' onclick='history.go(-1)'>
    </form>";
  }