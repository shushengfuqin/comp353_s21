<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  // header('Access-Control-Allow-Methods: POST');
  // header('Access-Control-Allow-Headers: Access-Control-Allow-Header, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Facility.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $facility = new Facility($db);

  // Get raw person data
  // $data = json_decode(file_get_contents("php://input"));

  // $person->p_id = $data->p_id;
  $facility->name = $_POST['name'];
  $facility->address = $_POST['address'];
  $facility->city = $_POST['city'];
  $facility->province = $_POST['province'];
  $facility->postal_code = $_POST['postal_code'];
  $facility->phone = $_POST['phone'];
  $facility->web = $_POST['web'];
  $facility->manager = $_POST['manager'];

  // Create person
  if($facility->create()) {
    // header("Location: read.php");
    echo '<script type="text/javascript">
           window.location = "read_facility.php"
      </script>';
  } else {
    echo "<form>
    <input type='button' value='Back' onclick='history.go(-1)'>
    </form>";
  }