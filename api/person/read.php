<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="">Home</a>
  <a href="#" class = "active">Person</a>
  <a href="#">Public Health Worker</a>
  <a href="#">Vaccination Type</a>
  <a href="#">COVID-19 Variants</a>
  <a href="#">Age Groups</a>
  <a href="#">Set Group Age for Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="#">Perform Vaccine</a>
  <a href="#">Other Query</a>
</div>

<div class="main">
<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');

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
    echo '<h1> Detailed Description of All Persons </h1>';
    echo '<table>';
    echo '<tr>'; 
    echo '<th> Person ID </th>';
    echo '<th> First Name </th>';
    echo '<th> Last Name </th>';
    echo '<th> Date of Birth </th>';
    echo '<th> Phone# </th>';
    echo '<th> Address </th>';
    echo '<th> City </th>';
    echo '<th> Province </th>';
    echo '<th> Postal Code</th>';
    echo '<th> email </th>';
    echo '</tr>';

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      echo '<tr>';
      echo '<td>'. $p_id .'</td>';
      echo '<td>'. $first_name .'</td>';
      echo '<td>'. $last_name .'</td>';
      echo '<td>'. $dob .'</td>';
      echo '<td>'. $phone .'</td>';
      echo '<td>'. $address .'</td>';
      echo '<td>'. $city .'</td>';
      echo '<td>'. $province .'</td>';
      echo '<td>'. $postal_code .'</td>';
      echo '<td>'. $email .'</td>';
      echo '</tr>';
    }
    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Person table is currently empty. <h1>";
  }
?>

</div>
</body>
</html>