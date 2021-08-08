<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Home</title>
</head>
<body>

<?php
  include('../../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../../index.php">Home</a>
  <a href="read.php">Person</a>
  <a href="#">Public Health Worker</a>
  <a href="#">Public Health Facility</a>
  <a href="#">Vaccination Type</a>
  <a href="#">COVID-19 Variants</a>
  <a href="#">Age Groups</a>
  <a href="#">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="#">Perform Vaccine</a>
  <a href="#">Other Query</a>
</div>

<div class="main">
<h1> Insert a Person (Please provide the following information) </h1>
<hr>
<form method='post' action='create.php'>

  <label> <b>First Name</b> </label>
  <input type=text placeholder="please enter first name..." name='first_name' required> </input>

  <label> <b>Last Name</b> </label>
  <input type=text placeholder="please enter last name..." name='last_name' required> </input>

  <label> <b>Date of Birth</b> </label>
  <input type=text placeholder="YYYY-MM-DD" name='dob' required> </input>

  <label> <b>Phone Number</b> </label>
  <input type=text placeholder="please enter phone number..." name='phone' required> </input>

  <label> <b>Address</b> </label>
  <input type=text placeholder="please enter address..." name='address' required> </input>

  <label> <b>City</b> </label>
  <input type=text placeholder="please enter city..." name='city' required> </input>

  <label> <b>Province</b> </label>
  <input type=text placeholder="please enter province..." name='province' required> </input>

  <label> <b>Postal Code</b> </label>
  <input type=text placeholder="please enter postal code..." name='postal_code' required> </input>

  <label> <b>Email Address</b> </label>
  <input type=text placeholder="please enter email..." name='email' required> </input>

  <label> <b>Citizenship</b> </label>
  <input type=text placeholder="please enter citizenship..." name='citizenship' required> </input>

  <input type=submit value='Insert'> </input>
</form>

</div>
</body>
</html>