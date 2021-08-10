<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Person</title>
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../../index.php">Home</a>
  <a href="read.php">Person</a>
  <a href="#">Public Health Worker</a>
  <a href="#">Public Health Facility</a>
  <a href="#">Vaccination Type</a>
  <a href="#">COVID-19 Variants</a>
  <a href="#">Age Groups</a>
  <a href="#">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="#">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
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

    // store the result in an array
    $person_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $person_item = array(
        'p_id' => $p_id,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'dob' => $dob,
        'phone' => $phone,
        'address' => $address,
        'city' => $city,
        'province' => $province,
        'postal_code' => $postal_code,
        'email' => $email
      );
      array_push($person_arr, $person_item);
    }

    // this section is to select one person and get the detailed information (including infection history) for that person
    echo "<div class='box'>";
    echo "<form method='get' action='readone.php'>";
    echo "<h2> Select a person ID to get detailed information (including infection history) of that person </h2>";
    echo "<select name='p_id'>";
    foreach($person_arr as $person){
      echo "<option value=". $person['p_id'] .">" . $person['p_id']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one person ************


    // button to add a new person
    echo "<h1 style='display: inline-block margin: 0'> All Persons Information <a href='create_UI.php'> <button class='header-button'> + Add New Person </button> </a> </h1>";

    // begin listing all persons
    echo '<table>';
    echo '<tr>'; 
    echo '<th> Person ID </th>';
    echo '<th> First Name </th>';
    echo '<th> Last Name </th>';
    echo '<th> Date of Birth </th>';
    // echo '<th> Phone# </th>';
    echo '<th> Address </th>';
    echo '<th> City </th>';
    echo '<th> Province </th>';
    // echo '<th> Postal Code</th>';
    // echo '<th> email </th>';
    echo '<th> Edit </th>';
    echo '<th> Delete </th>';
    echo '</tr>';

    foreach($person_arr as $person) {
      echo '<tr>';
      echo '<td>'. $person['p_id'] .'</td>';
      echo '<td>'. $person['first_name'] .'</td>';
      echo '<td>'. $person['last_name'] .'</td>';
      echo '<td>'. $person['dob'] .'</td>';
      // echo '<td>'. $person['phone'] .'</td>';
      echo '<td>'. $person['address'] .'</td>';
      echo '<td>'. $person['city'] .'</td>';
      echo '<td>'. $person['province'] .'</td>';
      // echo '<td>'. $person['postal_code'] .'</td>';
      // echo '<td>'. $person['email'] .'</td>';

      /* delete and edit button for the person - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI.php'>";
      echo "<button type='submit' name='edit' value='". $person['p_id'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete.php'>";
      echo "<button type='submit' name='delete' value='". $person['p_id'] ."'> Delete</button>";
      echo "</form> </td>";
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