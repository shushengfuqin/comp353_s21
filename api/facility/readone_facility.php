<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Person Information</title>
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
  include_once '../../models/Facility.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $facility = new Facility($db);

  // Get ID
  $facility->loc_id = isset($_GET['loc_id']) ? $_GET['loc_id'] : die();

  // Get person
  $facility->readone();

  echo '<h2> Facility Information </h2>';
  echo '<table>';
  echo '<tr>'; 
  echo '<th> Location ID </th>';
  echo '<th> Name </th>';
  echo '<th> Address </th>';
  echo '<th> City </th>';
  echo '<th> Province </th>';
  echo '<th> Postal Code </th>';
  echo '<th> Phone# </th>';
  echo '<th> WEB </th>';
  echo '<th> Type </th>';
  echo '<th> Manager ID </th>';
  echo '</tr>';

  echo '<tr>';
  echo '<td>'. $facility->loc_id .'</td>';
  echo '<td>'. $facility->name .'</td>';
  echo '<td>'. $facility->address .'</td>';
  echo '<td>'. $facility->city .'</td>';
  echo '<td>'. $facility->province .'</td>';
  echo '<td>'. $facility->postal_code .'</td>';
  echo '<td>'. $facility->phone .'</td>';
  echo '<td>'. $facility->web .'</td>';
  echo '<td>'. $facility->type .'</td>';
  echo '<td>'. $facility->manager .'</td> </tr>';
  echo '</table>';

  
?>

<form>
 <input type="button" value="Back" onclick="history.go(-1)">
</form>

</div>
</body>
</html>