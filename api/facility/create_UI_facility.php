<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Insert Facility</title>
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
  <a href="../../api/inventory/inventory_UI.php">Manage Vaccine Inventory</a>
  <a href="../../api/perform/perform.php">Perform Vaccine</a>
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">
<h1> Insert a Facility (Please provide the following information) </h1>
<hr>
<form method='post' action='create.php'>

  <label> <b>Name</b> </label>
  <input type=text placeholder="please enter name..." name='name' required> </input>

  <label> <b>Address</b> </label>
  <input type=text placeholder="please enter address..." name='address' required> </input>

  <label> <b>City</b> </label>
  <input type=text placeholder="please enter city..." name='city' required> </input>

  <label> <b>Province</b> </label>
  <input type=text placeholder="please enter province..." name='province' required> </input>

  <label> <b>Postal Code</b> </label>
  <input type=text placeholder="please enter postal code..." name='postal_code' required> </input>

  <label> <b>Phone Number</b> </label>
  <input type=text placeholder="please enter phone number..." name='phone' required> </input>

  

  
  <label> <b>WEB Address</b> </label>
  <input type=text placeholder="please enter web address..." name='web' required> </input>

  <label> <b>Manager ID</b> </label>
  <input type=text placeholder="please enter manager id..." name='manager' required> </input>

  <input type=submit value='Insert'> </input>
</form>

</div>
</body>
</html>