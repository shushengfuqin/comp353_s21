
<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  // header('Access-Control-Allow-Methods: POST');
  // header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Facility.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $facility = new Facility($db);

  //Set ID to update
  $facility->loc_id = $_POST['loc_id'];
    
  $facility->name = $_POST['name'];
  $facility->address = $_POST['address'];
  $facility->city = $_POST['city'];
  $facility->province = $_POST['province'];
  $facility->postal_code = $_POST['postal_code'];
  $facility->phone = $_POST['phone'];
  $facility->web = $_POST['web'];
  $facility->manager = $_POST['manager'];
  
    // Update post
    if($facility->update()) {
      // header("Location: read.php");
      echo '<script type="text/javascript">
           window.location = "read_facility.php"
      </script>';
    } else {
      echo "fail";
    }
?>

</div>
</body>
</html>