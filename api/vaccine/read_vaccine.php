<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Vaccine</title>
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
  <a href="../../api/facility/read_facility.php">Public Health Facility</a>
  <a href="read_vaccine.php">Vaccination Type</a>
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
  include_once '../../models/Vaccine.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog vaccine object
  $vaccine = new Vaccine($db);

  // Blog vaccine query
  $result = $vaccine->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any vaccine
  if($num > 0) {

    // store the result in an array
    $vaccine_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $vaccine_item = array(
        'vac_id' => $vac_id,
        'name' => $name,
        'vac_desc' => $vac_desc,
        'status' => $status
      );
      array_push($vaccine_arr, $vaccine_item);
    }

    // this section is to select one vaccine and get the detailed information  for that vaccine
    echo "<div class='box'>";
    echo "<form method='get' action='readone_vaccine.php'>";
    echo "<h2> Select a vaccine ID to get detailed information of that vaccine </h2>";
    echo "<select name='vac_id'>";
    foreach($vaccine_arr as $vaccine){
      echo "<option value=". $vaccine['vac_id'] .">" . $vaccine['vac_id']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one vaccine ************


    // button to add a new vaccine
    echo "<h1 style='display: inline-block margin: 0'> All Vaccines Information <a href='create_UI_vaccine.php'> <button class='header-button'> + Add New Vaccine </button> </a> </h1>";

    // begin listing all vaccines
    echo '<table>';
    echo '<tr>'; 
    //echo '<th> Facility ID </th>';
    echo '<th> ID </th>';
    echo '<th> name </th>';
    echo '<th> vac_desc </th>';
    echo '<th> status </th>';
    echo '<th> Edit </th>';
    echo '<th> Delete </th>';
    echo '</tr>';

    foreach($vaccine_arr as $vaccine) {
      echo '<tr>';
      echo '<td>'. $vaccine['vac_id'] .'</td>';
      echo '<td>'. $vaccine['name'] .'</td>';
       echo '<td>'. $vaccine['vac_desc'] .'</td>';
        echo '<td>'. $vaccine['status'] .'</td>';
      
      /* delete and edit button for the vaccine - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI_vaccine.php'>";
      echo "<button type='submit' name='edit' value='". $vaccine['vac_id'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete_vaccine.php'>";
      echo "<button type='submit' name='delete' value='". $vaccine['vac_id'] ."'> Delete</button>";
      echo "</form> </td>";
      echo '</tr>';
    }

    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Vaccine table is currently empty. <h1>";
  }
?>

</div>
</body>
</html>