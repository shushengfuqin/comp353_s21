<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Update Person</title>
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../../index.php">Home</a>
  <a href="read.php">Person</a>
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
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $person = new Person($db);

  // Get ID
  $person->p_id = isset($_GET['edit']) ? $_GET['edit'] : die();

  // Get person
  $person->readone();
?>


<div class="main">
<h1> Update a Person </h1>
<hr>
<form method='post' action='update.php'>

  <label> <b> ID </b> </label>
  <?php
    echo "<input type=text name='p_id' value='". $person->p_id. "' onfocus=blur()>";
  ?>

  <label> <b>First Name</b> </label>
  <?php
    echo "<input type=text name='first_name' value='". $person->first_name. "' required>";
  ?>

  <label> <b>Last Name</b> </label>
  <?php
    echo "<input type=text name='last_name' value='". $person->last_name. "' required>";
  ?>

  <label> <b>Date of Birth</b> </label>
  <?php
    echo "<input type=text name='dob' value='". $person->dob. "' required>";
  ?>

  <label> <b>Phone Number</b> </label>
  <?php
    echo "<input type=text name='phone' value='". $person->phone. "' required>";
  ?>

  <label> <b>Address</b> </label>
  <?php
    echo "<input type=text name='address' value='". $person->address. "' required>";
  ?>

  <label> <b>City</b> </label>
  <?php
    echo "<input type=text name='city' value='". $person->city. "' required>";
  ?>

  <label> <b>Province</b> </label>
  <?php
    echo "<input type=text name='province' value='". $person->province. "' required>";
  ?>

  <label> <b>Postal Code</b> </label>
  <?php
    echo "<input type=text name='postal_code' value='". $person->postal_code. "' required>";
  ?>

  <label> <b>Email Address</b> </label>
  <?php
    echo "<input type=text name='email' value='". $person->email. "' required>";
  ?>

  <label> <b>Citizenship</b> </label>
  <?php
    echo "<input type=text name='citizenship' value='". $person->citizenship. "' required>";
  ?>

  <input type=submit value='Update'> </input>
</form>

</div>
</body>
</html>