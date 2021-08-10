<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Home</title>
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

    <h3> (12) Get details of all the people who got vaccinated only one dose and are of group ages 1 to 3 (first-name, last-name, date of birth, email, phone, city, date of vaccination, vaccination type, been infected by COVID-19 before or not). </h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT p.first_name, p.last_name, p.dob, p.email, p.phone, p.city,v.vdate, va.name AS vaccination_type,IF(inf.p_id IS NOT NULL,'YES','NO') AS 'infected'
        FROM person p
        JOIN vaccination v ON p.p_id = v.p_id
        JOIN vaccine va ON v.vac_id = va.vac_id
        LEFT JOIN  (SELECT DISTINCT(p_id) FROM infection) AS inf ON inf.p_id = p.p_id
        WHERE (p.p_id IN (SELECT p_id
          FROM vaccination
          GROUP BY p_id
          HAVING COUNT(dose_num)=1))
      AND (TRUNCATE(DATEDIFF(CURDATE(), p.dob) / 365, 0) BETWEEN (SELECT
      lower_limit FROM age_group WHERE grp_id = 3) AND (SELECT upper_limit FROM
          age_group WHERE grp_id = 1));";

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
        echo "<th> Has Been Infected </th> </tr>";

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
          echo "<td>". $infected ."</td>";
          echo "</tr>";
        }

        echo "</table>";
    ?>


</div>
</body>
</html>