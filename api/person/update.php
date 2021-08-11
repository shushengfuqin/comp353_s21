
<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');
  // header('Access-Control-Allow-Methods: POST');
  // header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $person = new Person($db);

  //Set ID to update
  $person->p_id = $_POST['p_id'];
    
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
  
    // Update post
    if($person->update()) {
      // header("Location: read.php");
      echo '<script type="text/javascript">
           window.location = "read.php"
      </script>';
    } else {
      echo "fail";
    }
?>

</div>
</body>
</html>