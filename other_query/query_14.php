<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 14</title>
</head>
<body>

<?php
  include('../includes/header.php');
?>

<!-- menu -->
<div class="sidebar">
  <a href="../index.php">Home</a>
  <a href="../api/person/read.php">Person</a>
  <a href="#">Public Health Worker</a>
  <a href="#">Public Health Facility</a>
  <a href="#">Vaccination Type</a>
  <a href="#">COVID-19 Variants</a>
  <a href="#">Age Groups</a>
  <a href="#">Manage Province</a>
  <a href="#">Manage Vaccine Inventory</a>
  <a href="#">Perform Vaccine</a>
  <a href="other_query_UI.php">Other Query</a>
</div>

<div class="main">

    <h3> (14) Get details of all the people who got vaccinated and have been infected with at least two different variants of Covid-19 (first-name, last-name, date of birth, email, phone, city, date of vaccination, vaccination type, number of times being infected by COVID-19 variants) </h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT p.first_name, p.last_name, p.dob, p.email, p.phone, p.city, v.vdate, va.name AS vaccination_type, COUNT(p.p_id)AS infected_times
          FROM person p
          JOIN vaccination v ON p.p_id = v.p_id
          JOIN vaccine va ON v.vac_id = va.vac_id
          JOIN infection i ON i.p_id = p.p_id
          WHERE p.p_id IN (SELECT DISTINCT(inf1.p_id)
                  FROM  infection inf1, infection inf2 
                  WHERE (inf1.type != inf2.type)  AND  ( inf1.p_id = inf2.p_id))
          GROUP BY p.p_id;";

        $stmt = $db->prepare($query);

        // Execute query
        $stmt->execute();

        // table header
        echo "<table><tr>";
        echo "<th> First Name </th>";
        echo "<th> Last Name </th>";
        echo "<th> Date of Birth </th>";
        echo "<th> Email </th>";
        echo "<th> Phone # </th>";
        echo "<th> City </th>";
        echo "<th> Vaccination Date </th>";
        echo "<th> Vaccination Type </th>";
        echo "<th> Infected Times </th> </tr>";

        // extract data from stmt
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          echo "<tr>";
          echo "<td>". $first_name ."</td>";
          echo "<td>". $last_name ."</td>";
          echo "<td>". $dob ."</td>";
          echo "<td>". $email ."</td>";
          echo "<td>". $phone ."</td>";
          echo "<td>". $city ."</td>";
          echo "<td>". $vdate ."</td>";
          echo "<td>". $vaccination_type ."</td>";
          echo "<td>". $infected_times ."</td>";
          echo "</tr>";
        }

        echo "</table>";

        // echo "<h3> SQL Query </h3>";
        // echo "<p>". $query ."</p>";
    ?>
<form>
 <input type="button" value="Back" onclick="history.go(-1)">
</form>


</div>
</body>
</html>