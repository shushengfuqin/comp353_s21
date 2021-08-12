<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Facility</title>
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../../index.php">Home</a>
  <a href="../../api/person/read.php">Person</a>
  <a href="../../api/worker/read_worker.php">Public Health Worker</a>
  <a href="read_facility.php">Public Health Facility</a>
  <a href="../../api/vaccine/read_vaccine.php">Vaccination Type</a>
  <a href="../../api/variant/read_variant.php">COVID-19 Variants</a>
  <a href="../../api/agegroup/read_agegroup.php">Age Groups</a>
  <a href="../../api/province/read_province.php">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="#">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">
<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Facility.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $facility = new Facility($db);

  // Blog person query
  $result = $facility->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any persons
  if($num > 0) {

    // store the result in an array
    $facility_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $facility_item = array(
        'loc_id' => $loc_id,
        'name' => $name,
        'address' => $address,
        'city' => $city,
        'province' => $province,
        'postal_code' => $postal_code,
        'phone' => $phone,
        'web' => $web,
        'type' => $type,
        'manager' => $manager
      );
      array_push($facility_arr, $facility_item);
    }

    // this section is to select one facility and get the detailed information  for that facility
    echo "<div class='box'>";
    echo "<form method='get' action='readone_facility.php'>";
    echo "<h2> Select a facility ID to get detailed information of that facility </h2>";
    echo "<select name='loc_id'>";
    foreach($facility_arr as $facility){
      echo "<option value=". $facility['loc_id'] .">" . $facility['loc_id']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one facility ************


    // button to add a new facility
    echo "<h1 style='display: inline-block margin: 0'> All Facilities Information <a href='create_UI_facility.php'> <button class='header-button'> + Add New Facility </button> </a> </h1>";

    // begin listing all facilities
    echo '<table>';
    echo '<tr>'; 
    //echo '<th> Facility ID </th>';
    echo '<th> Name </th>';
    echo '<th> Address </th>';
    echo '<th> City </th>';
    echo '<th> Province </th>';
    echo '<th> Postal Code</th>';
    echo '<th> Phone </th>';
    echo '<th> WEB </th>';
    echo '<th> Manager ID </th>';
    echo '<th> Edit </th>';
    echo '<th> Delete </th>';
    echo '</tr>';

    foreach($facility_arr as $facility) {
      echo '<tr>';
      // '<td>'. $facility['loc_id'] .'</td>';
      echo '<td>'. $facility['name'] .'</td>';
      echo '<td>'. $facility['address'] .'</td>';
      echo '<td>'. $facility['city'] .'</td>';
      echo '<td>'. $facility['province'] .'</td>';
      echo '<td>'. $facility['postal_code'] .'</td>';
      echo '<td>'. $facility['phone'] .'</td>';
      echo '<td>'. $facility['web'] .'</td>';
      echo '<td>'. $facility['manager'] .'</td>';
      /* delete and edit button for the facility - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI_facility.php'>";
      echo "<button type='submit' name='edit' value='". $facility['loc_id'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete_facility.php'>";
      echo "<button type='submit' name='delete' value='". $facility['loc_id'] ."'> Delete</button>";
      echo "</form> </td>";
      echo '</tr>';
    }

    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Facility table is currently empty. <h1>";
  }
?>

</div>
</body>
</html>