<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 13</title>
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

    <h3> (13) Get details of all the people who live in the city of Montréal and who got vaccinated at least two doses of different types of vaccines. (First name, last name, date of birth, email, phone, city, date of vaccination, vaccination type, been infected by COVID-19 before or not). </h3>

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
          WHERE p.p_id IN (SELECT v1.p_id
                    FROM (SELECT p_id, dose_num, vac_id
                        FROM vaccination 
                        WHERE p_id IN (SELECT p_id
                                FROM vaccination
                                GROUP BY p_id
                                HAVING COUNT(dose_num)>1)
                            AND dose_num > 1)AS v1
                    JOIN
                      (SELECT p_id, dose_num, vac_id
                        FROM vaccination 
                        WHERE p_id IN (SELECT p_id
                                FROM vaccination
                                GROUP BY p_id
                                HAVING COUNT(dose_num)>1)
                            AND dose_num = 1)AS v2 ON v2.p_id = v1.p_id
                    WHERE v1.vac_id != v2.vac_id)
             AND (p.city = 'Montreal');";

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
<form>
 <input type="button" value="Back" onclick="history.go(-1)">
</form>


</div>
</body>
</html>