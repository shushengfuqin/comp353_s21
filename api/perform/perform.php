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
</div>
</body>
</html>