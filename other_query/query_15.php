<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 15</title>
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

    <h3> (15) Give a report of the inventory of vaccines in each province. The report should include for each province and for each type of vaccine, the total number of vaccines available in the province. The report should be displayed in ascending order by province then by descending order of number of vaccines in the inventory </h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT f.province, v.name AS vaccine_type,SUM(i.quantity)AS total
          FROM facility f 
          JOIN inventory i ON i.loc_id = f.loc_id
          JOIN vaccine v ON v.vac_id = i.vac_id
          GROUP BY f.province,i.vac_id
          ORDER BY f.province, vaccine_type DESC;";

        $stmt = $db->prepare($query);

        // Execute query
        $stmt->execute();

        // table header
        echo "<table><tr>";
        echo "<th> Province </th>";
        echo "<th> Vaccination Type </th>";
        echo "<th> Total Number </th> </tr>";

        // extract data from stmt
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          echo "<tr>";
          echo "<td>". $province ."</td>";
          echo "<td>". $vaccine_type ."</td>";
          echo "<td>". $total ."</td>";
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