<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Variant</title>
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
  <a href="read_variant.php">COVID-19 Variants</a>
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
  include_once '../../models/Variant.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog variant object
  $variant = new Variant($db);

  // Blog variant query
  $result = $variant->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any variant
  if($num > 0) {

    // store the result in an array
    $variant_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $variant_item = array(
        'variant_id' => $variant_id,
        'variant_name' => $variant_name
        
      );
      array_push($variant_arr, $variant_item);
    }

    // this section is to select one variant and get the detailed information  for that variant
    echo "<div class='box'>";
    echo "<form method='get' action='readone_variant.php'>";
    echo "<h2> Select a variant ID to get detailed information of that variant </h2>";
    echo "<select name='variant_id'>";
    foreach($variant_arr as $variant){
      echo "<option value=". $variant['variant_id'] .">" . $variant['variant_id']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one variant ************


    // button to add a new variant
    echo "<h1 style='display: inline-block margin: 0'> All Variants Information <a href='create_UI_variant.php'> <button class='header-button'> + Add New Variant </button> </a> </h1>";

    // begin listing all variants
    echo '<table>';
    echo '<tr>'; 
    //echo '<th> Facility ID </th>';
    echo '<th> ID </th>';
    echo '<th> Name </th>';
    echo '</tr>';

    foreach($variant_arr as $variant) {
      echo '<tr>';
      // '<td>'. $facility['loc_id'] .'</td>';
      echo '<td>'. $variant['variant_id'] .'</td>';
      echo '<td>'. $variant['variant_name'] .'</td>';
      
      /* delete and edit button for the variant - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI_variant.php'>";
      echo "<button type='submit' name='edit' value='". $variant['variant_id'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete_variant.php'>";
      echo "<button type='submit' name='delete' value='". $variant['variant_id'] ."'> Delete</button>";
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