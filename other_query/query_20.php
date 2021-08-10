<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 20</title>
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

    <h3> (20) Give a list of all public health workers in Québec who never been vaccinated or who have been vaccinated only one dose for Covid-19 (EmployeeID, first-name, last-name, date of birth, telephone-number, city, email address, locations name where the employee work).</h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT hw.emp_id, p.first_name, p.last_name, p.dob, p.phone, p.city, p.email, f.name AS location_name
          FROM health_worker hw
          JOIN person p ON p.p_id = hw.p_id 
          JOIN work_history wh ON hw.emp_id = wh.emp_id         
          JOIN facility f ON wh.loc_id = f.loc_id
          WHERE p.province = 'QC' AND hw.p_id NOT IN (SELECT p_id
                                FROM vaccination
                                GROUP BY p_id
                                HAVING COUNT(p_id)>1);";

        $stmt = $db->prepare($query);

        // Execute query
        $stmt->execute();

        // table header
        echo "<table><tr>";
        echo "<th> Employee ID </th>";
        echo "<th> First Name </th>";
        echo "<th> Last Name </th>";
        echo "<th> Date of Birth </th>";
        echo "<th> Phone # </th>";
        echo "<th> City </th>";
        echo "<th> Email </th>";
        echo "<th> Facility Name </th> </tr>";

        // extract data from stmt
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          echo "<tr>";
          echo "<td>". $emp_id ."</td>";
          echo "<td>". $first_name ."</td>";
          echo "<td>". $last_name ."</td>";
          echo "<td>". $dob ."</td>";
          echo "<td>". $phone ."</td>";
          echo "<td>". $city ."</td>";
          echo "<td>". $email ."</td>";
          echo "<td>". $location_name ."</td>";
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