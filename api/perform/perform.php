<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Perform Vaccine</title>
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../../index.php">Home</a>
  <a href="../person/read.php">Person</a>
  <a href="../../api/worker/read_worker.php">Public Health Worker</a>
  <a href="../../api/facility/read_facility.php">Public Health Facility</a>
  <a href="../../api/vaccine/read_vaccine.php">Vaccination Type</a>
  <a href="../../api/variant/read_variant.php">COVID-19 Variants</a>
  <a href="../../api/agegroup/read_agegroup.php">Age Groups</a>
  <a href="../../api/province/read_province.php">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="../../api/perform/perform.php">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">


    <h3> Please fill out the following information to perform a vaccine </h3>
    <form method="post" action="perform_transaction.php">
    <label> <b>Person ID</b> </label>
    <input type=text placeholder="please enter person ID" name='p_id' required> </input>

    <label> <b>Dose Number</b> </label>
    <select name="dose_num">
      <option>1</option>
      <option>2</option>
    </select>

    <label> <b>Employee ID</b> </label>
    <input type=text placeholder="please enter Employee ID..." name='emp_id' required> </input>

    <label> <b>Vaccine Type</b> </label>
    <select name="vac_id">
      <option>Pfizer-BioNTech</option>
      <option>Moderna</option>
      <option>AstraZeneca</option>
      <option>Johnson & Johnson</option>
    </select>

    <label> <b>Location ID</b> </label>
    <input type=text placeholder="please enter location ID..." name='loc_id' required> </input>

    <label> <b>Date</b> </label>
    <input type=text placeholder="please enter Date..." name='vdate' required> </input>

  <input type='submit' value='Perform'>
  </form>

  <!-- Print vaccination -->
  <?php 

  include_once '../../config/Database.php';
  include_once '../../models/Vaccination.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $vaccination = new Vaccination($db);

  // Blog person query
  $result = $vaccination->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any persons
  if($num > 0) {

    // store the result in an array
    $vac_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $vac_item = array(
        'p_id' => $p_id,
        'dose_num' => $dose_num,
        'emp_id' => $emp_id,
        'vac_id' => $vac_id,
        'loc_id' => $loc_id,
        'vdate' => $vdate,
      );
      array_push($vac_arr, $vac_item);
    }

    // begin listing all facilities
    echo '<table>';
    echo '<tr>'; 
    echo '<th> Person ID </th>';
    echo '<th> Dose Number </th>';
    echo '<th> Employee ID </th>';
    echo '<th> Vaccination ID </th>';
    echo '<th> Facility ID </th>';
    echo '<th> Vaccination Date</th>';
    echo '</tr>';

    foreach($vac_arr as $v) {
      echo '<tr>';
      echo '<td>'. $v['p_id'] .'</td>';
      echo '<td>'. $v['dose_num'] .'</td>';
      echo '<td>'. $v['emp_id'] .'</td>';
      echo '<td>'. $v['vac_id'] .'</td>';
      echo '<td>'. $v['loc_id'] .'</td>';
      echo '<td>'. $v['vdate'] .'</td>';
      echo "</tr>";
    }

    echo '</table>';

  } 
  else {
    echo "<h1 style='color:red'> Vaccination table is currently empty. <h1>";
  }
?>
</div>
</body>
</html>