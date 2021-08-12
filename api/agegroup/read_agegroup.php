<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Age Group</title>
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
  <a href="../../api/vaccine/read_vaccine.php">Vaccination Type</a>
  <a href="../../api/variant/read_variant.php">COVID-19 Variants</a>
  <a href="read_agegroup.php">Age Groups</a>
  <a href="../../api/province/read_province.php">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="../../api/perform/perform.php">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">
<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/AgeGroup.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog age group object
  $age = new AgeGroup($db);

  // Blog age group query
  $result = $age->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any age group
  if($num > 0) {

    // store the result in an array
    $age_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $age_item = array(
        'grp_id' => $grp_id,
        'upper_limit' => $upper_limit,
        'lower_limit' => $lower_limit
        
      );
      array_push($age_arr, $age_item);
    }

    // this section is to select one age group and get the detailed information  for that age group
    echo "<div class='box'>";
    echo "<form method='get' action='readone_variant.php'>";
    echo "<h2> Select a age group ID to get detailed information of that age group </h2>";
    echo "<select name='grp_id'>";
    foreach($age_arr as $age){
      echo "<option value=". $age['grp_id'] .">" . $age['grp_id']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one variant ************


    // button to add a new age group
    echo "<h1 style='display: inline-block margin: 0'> All age groups Information <a href='create_UI_agegroup.php'> <button class='header-button'> + Add New Age Group </button> </a> </h1>";

    // begin listing all age groups
    echo '<table>';
    echo '<tr>'; 
    //echo '<th> Facility ID </th>';
    echo '<th> Group ID </th>';
    echo '<th> Upper limit </th>';
    echo '<th> Lower limit </th>';
    echo '<th> Edit </th>';
    echo '<th> Delete </th>';
    echo '</tr>';

    foreach($age_arr as $age) {
      echo '<tr>';
      // '<td>'. $facility['loc_id'] .'</td>';
      echo '<td>'. $age['grp_id'] .'</td>';
      echo '<td>'. $age['upper_limit'] .'</td>';
      echo '<td>'. $age['lower_limit'] .'</td>';
      
      /* delete and edit button for the age group - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI_agegroup.php'>";
      echo "<button type='submit' name='edit' value='". $age['grp_id'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete_agegroup.php'>";
      echo "<button type='submit' name='delete' value='". $age['grp_id'] ."'> Delete</button>";
      echo "</form> </td>";
      echo '</tr>';
    }

    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Variant table is currently empty. <h1>";
  }
?>

</div>
</body>
</html>