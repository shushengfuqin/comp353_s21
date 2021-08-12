<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Update Facility</title>
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
  $facility->loc_id = isset($_GET['edit']) ? $_GET['edit'] : die();

  // Get person
  $facility->readone();
?>


<div class="main">
<h1> Update a facility </h1>
<hr>
<form method='post' action='update_facility.php'>

  <label> <b> ID </b> </label>
  <?php
    echo "<input type=text name='p_id' value='". $facility->loc_id. "' onfocus=blur()>";
  ?>

  <label> <b>First Name</b> </label>
  <?php
    echo "<input type=text name='first_name' value='". $facility->name. "' required>";
  ?>


  <label> <b>Address</b> </label>
  <?php
    echo "<input type=text name='address' value='". $facility->address. "' required>";
  ?>

  <label> <b>City</b> </label>
  <?php
    echo "<input type=text name='city' value='". $facility->city. "' required>";
  ?>

  <label> <b>Province</b> </label>
  <?php
    echo "<input type=text name='province' value='". $facility->province. "' required>";
  ?>

  <label> <b>Postal Code</b> </label>
  <?php
    echo "<input type=text name='postal_code' value='". $facility->postal_code. "' required>";
  ?>

  <label> <b>Phone Number</b> </label>
  <?php
    echo "<input type=text name='phone' value='". $facility->phone. "' required>";
  ?>


  <label> <b>Web Address</b> </label>
  <?php
    echo "<input type=text name='email' value='". $facility->web. "' required>";
  ?>

  <label> <b>Manager ID</b> </label>
  <?php
    echo "<input type=text name='citizenship' value='". $facility->manager. "' required>";
  ?>

  <input type=submit value='Update'> </input>
</form>

</div>
</body>
</html>