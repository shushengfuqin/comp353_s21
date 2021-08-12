<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Manage Worker</title>
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../../index.php">Home</a>
  <a href="../../api/person/read.php">Person</a>
  <a href="read_worker.php">Public Health Worker</a>
  <a href="../../api/facility/read_facility.php">Public Health Facility</a>
  <a href="../../api/vaccine/read_vaccine.php">Vaccination Type</a>
  <a href="../../api/variant/read_variant.php">COVID-19 Variants</a>
  <a href="../../api/agegroup/read_agegroup.php">Age Groups</a>
  <a href="../../api/province/read_province.php">Manage Province</a>
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
  include_once '../../models/Worker.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog worker object
  $worker = new Worker($db);

  // Blog worker query
  $result = $worker->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any workers
  if($num > 0) {

    // store the result in an array
    $worker_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $worker_item = array(
        'p_id' => $p_id,
        'emp_id' => $emp_id
        
      );
      array_push($worker_arr, $worker_item);
    }

    // this section is to select one worker and get the detailed information  for that worker
    echo "<div class='box'>";
    echo "<form method='get' action='readone_worker.php'>";
    echo "<h2> Select a worker ID to get detailed information of that worker </h2>";
    echo "<select name='p_id'>";
    foreach($worker_arr as $worker){
      echo "<option value=". $worker['p_id'] .">" . $worker['p_id']. "</option>";
    }
    echo "</option>";
    echo "<input type='submit' value='Check'>";
    echo "</form>";
    echo "</div>";
    // ************ end of requesting one worker ************


    // button to add a new worker
    echo "<h1 style='display: inline-block margin: 0'> All Workers Information <a href='create_UI_worker.php'> <button class='header-button'> + Add New Worker </button> </a> </h1>";

    // begin listing all workers
    echo '<table>';
    echo '<tr>'; 
    //echo '<th> Facility ID </th>';
    echo '<th> ID </th>';
    echo '<th> emp_id </th>';
    echo '<th> Edit </th>';
    echo '<th> Delete </th>';
    echo '</tr>';

    foreach($worker_arr as $worker) {
      echo '<tr>';
      // '<td>'. $facility['loc_id'] .'</td>';
      echo '<td>'. $worker['p_id'] .'</td>';
      echo '<td>'. $worker['emp_id'] .'</td>';
      
      /* delete and edit button for the worker - requires two separate forms */
      echo "<td>";
      echo "<form method='get' action='update_UI_worker.php'>";
      echo "<button type='submit' name='edit' value='". $worker['p_id'] ."'> Edit</button>";
      echo "</form> </td>";

      echo "<td>";
      echo "<form method='get' action='delete_worker.php'>";
      echo "<button type='submit' name='delete' value='". $worker['p_id'] ."'> Delete</button>";
      echo "</form> </td>";
      echo '</tr>';
    }

    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Worker table is currently empty. <h1>";
  }
?>

</div>
</body>
</html>