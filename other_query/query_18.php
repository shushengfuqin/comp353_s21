<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 18</title>
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

    <h3> (18) Give a detailed report of all the facilities in the city of Montréal. The report should include the name, address, type and phone number of the facility, the total number of public health workers working in the facility, the total number of shipments of vaccines received by the facility, the total number of doses received by the facility, the total number of transfer of vaccines from the facility and transfer to the facility, the total number of doses transferred from the facility, the total number of doses transferred to the facility, the total number of vaccines of each type in the facility, the number of people vaccinated in the facility, and the number of doses people have received in the facility.</h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT f.loc_id, f.name, f.address, f.type, f.phone, emp.total_emp, s.total_shipment, t.total_from_loc, tt.total_to_loc, i.Pfizer_Moderna_AZ_Johnson, p.total_people, v.total_dose
          FROM facility f
          LEFT JOIN (SELECT wh.loc_id, COUNT(wh.emp_id)AS total_emp
              FROM  work_history wh
              WHERE wh.end_date IS NULL
              GROUP BY wh.loc_id)AS emp ON emp.loc_id = f.loc_id
          LEFT JOIN (SELECT s1.loc_id, SUM(s1.quantity)AS total_shipment
              FROM shipment s1 
              GROUP BY s1.loc_id)AS s ON s.loc_id = f.loc_id
          LEFT JOIN (SELECT t1.from_loc, SUM(t1.quantity)AS total_from_loc
              FROM transfer t1 
              GROUP BY t1.from_loc)AS t ON t.from_loc = f.loc_id
          LEFT JOIN (SELECT t2.to_loc, SUM(t2.quantity)AS total_to_loc
              FROM transfer t2 
              GROUP BY t2.to_loc)AS tt ON tt.to_loc = f.loc_id
          LEFT JOIN (SELECT inv.loc_id,GROUP_CONCAT(inv.quantity)AS Pfizer_Moderna_AZ_Johnson
              FROM inventory inv
              GROUP BY inv.loc_id) AS i ON i.loc_id = f.loc_id
          LEFT JOIN (SELECT peop.loc_id, COUNT(peop.p_id)AS total_people
                FROM (SELECT va.loc_id, va.p_id
                    FROM vaccination va 
                    GROUP BY va.loc_id, va.p_id)AS peop
                GROUP BY peop.loc_id)AS p ON p.loc_id = f.loc_id
          LEFT JOIN (SELECT va.loc_id, COUNT(va.dose_num)AS total_dose
                FROM vaccination va 
                GROUP BY va.loc_id)AS v ON v.loc_id = f.loc_id;";

        $stmt = $db->prepare($query);

        // Execute query
        $stmt->execute();

        // table header
        echo "<table><tr>";
        echo "<th> Facility Name </th>";
        echo "<th> Address </th>";
        echo "<th> Facility Type </th>";
        echo "<th> Phone # </th>";
        echo "<th> # of Employees </th>";
        echo "<th> Shipment # </th>";
        echo "<th> Doses Transfer From </th>";
        echo "<th> Doses Transfer To </th>";
        echo "<th> Pfizer, Moderna, AZ, J&J </th>";
        echo "<th> # of People Received Vaccine </th>";
        echo "<th> Total Dose </th> </tr>";

        // extract data from stmt
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          echo "<tr>";
          echo "<td>". $name ."</td>";
          echo "<td>". $address ."</td>";
          echo "<td>". $type ."</td>";
          echo "<td>". $phone ."</td>";
          echo "<td>". $total_emp ."</td>";
          echo "<td>". $total_shipment ."</td>";
          echo "<td>". $total_from_loc ."</td>";
          echo "<td>". $total_to_loc ."</td>";
          echo "<td>". $Pfizer_Moderna_AZ_Johnson ."</td>";
          echo "<td>". $total_people ."</td>";
          echo "<td>". $total_dose ."</td>";
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