<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Inventory Management</title>
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
  <a href="../../api/inventory/inventory_UI.php">Manage Vaccine Inventory</a>
  <a href="../../api/perform/perform.php">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">

  <!-- form to perform shipment -->
  <div class = "box">
    <h3> Please fill out the following information to perform a shipment </h3>
    <form method="post" action="shipment.php">
    <label> <b>Destination Location ID</b> </label>
    <input type=text placeholder="location id" name='loc_id' required> </input>

    <label> <b>Shipment Date</b> </label>
    <input type=text placeholder="please enter Date..." name='sdate' required> </input>

    <label> <b>Vaccine Type</b> </label>
    <select name="vac_id">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
    </select>

    <label> <b>Quantity</b> </label>
    <input type=text placeholder="please enter quantity..." name='quantity' required> </input>

  <input type='submit' value='Ship'>
  </form>
</div>

  <p></p>

  <!-- another form to perform transfer -->
  <div class="box">
    <form method="post" action="transfer.php">
    <h3> Please fill out the following information to perform a transfer </h3>

    <label> <b>Origin Location ID</b> </label>
    <input type=text placeholder="from location id" name='from_loc' required> </input>

    <label> <b>Destination Location ID</b> </label>
    <input type=text placeholder="to location id" name='to_loc' required> </input>

    <label> <b>Transfer Date</b> </label>
    <input type=text placeholder="please enter Date..." name='tdate' required> </input>

    <label> <b>Vaccine Type</b> </label>
    <select name="vac_id">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
    </select>

    <label> <b>Quantity</b> </label>
    <input type=text placeholder="please enter quantity..." name='quantity' required> </input>

  <input type='submit' value='Transfer'>
    </form>
  </div>


  <h2> Inventory Information </h2>
  <!-- Print Inventory Information -->
  <?php 

  include_once '../../config/Database.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  $query = "SELECT * FROM inventory";
  $stmt = $db->prepare($query);
  $stmt->execute();

  $num = $stmt->rowCount();

  // Check if any persons
  if($num > 0) {

    // store the result in an array
    $inv_arr = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $inv_item = array(
        'loc_id' => $loc_id,
        'vac_id' => $vac_id,
        'quantity' => $quantity
      );
      array_push($inv_arr, $inv_item);
    }

    // begin listing all facilities
    echo '<table>';
    echo '<tr>'; 
    echo '<th> Location ID </th>';
    echo '<th> Vaccination ID </th>';
    echo '<th> Quantity </th>';
    echo '</tr>';

    foreach($inv_arr as $i) {
      echo '<tr>';
      echo '<td>'. $i['loc_id'] .'</td>';
      echo '<td>'. $i['vac_id'] .'</td>';
      echo '<td>'. $i['quantity'] .'</td>';
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