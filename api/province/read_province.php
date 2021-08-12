<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Province</title>
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
  <a href="../../api/agegroup/read_agegroup.php">Age Groups</a>
  <a href="read_province.php">Manage Province</a>
  <a href="../../api/inventory/inventory_UI.php">Manage Vaccine Inventory</a>
  <a href="../../api/perform/perform.php">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">
<?php 
  // Headers
  // header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Province.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog province object
  $province = new Province($db);

  // Blog province query
  $result = $province->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any province
  if($num > 0) {

    // store the result in an array
    $province_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $province_item = array(
        'province' => $province,
        'grp_id' => $grp_id
        
      );
      array_push($province_arr, $province_item);
    }

    // this section is to select one province and get the detailed information  for that province
    echo "<div class='box'>";
    echo "<form method='get' action='readone_province.php'>";
    echo "<h2> Select a province to get detailed information of that province </h2>";
    echo "<select name='province'>";
    foreach($province_arr as $province){
      echo "<option value=". $province['province'] .">" . $province['province']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one worker ************


    // button to add a new province
    echo "<h1 style='display: inline-block margin: 0'> All provinces Information <a href='create_UI_province.php'> <button class='header-button'> + Add New Province </button> </a> </h1>";

    // begin listing all Provinces
    echo '<table>';
    echo '<tr>'; 
    //echo '<th> Facility ID </th>';
    echo '<th> province </th>';
    echo '<th> grp_id </th>';
    echo '<th> Edit </th>';
    echo '<th> Delete </th>';
    echo '</tr>';

    foreach($province_arr as $province) {
      echo '<tr>';
      // '<td>'. $facility['loc_id'] .'</td>';
      echo '<td>'. $province['province'] .'</td>';
      echo '<td>'. $province['grp_id'] .'</td>';
      
      /* delete and edit button for the province - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI_province.php'>";
      echo "<button type='submit' name='edit' value='". $province['province'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete_province.php'>";
      echo "<button type='submit' name='delete' value='". $province['province'] ."'> Delete</button>";
      echo "</form> </td>";
      echo '</tr>';
    }

    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Province table is currently empty. <h1>";
  }
?>

</div>
</body>
</html>