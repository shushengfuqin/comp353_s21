<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 16</title>
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

    <h3> (16) Give a report of the population’s vaccination by province between January 1st2021 and July 22nd 2021. The report should include for each province and for each type of vaccine, the total number of people using the type of vaccine. If a person have been vaccinated with Pfizer twice then the person will be counted only once for Pfizer. But if a person have been vaccinated one dose for Pfizer and one dose for Moderna then the person is counted once for each type.</h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT pop.province, pop.type_vaccine,COUNT(pop.p_id)AS total_num
                  FROM
                  (SELECT f.province, va.name AS type_vaccine, v.p_id
                  FROM vaccination v          
                  JOIN facility f ON v.loc_id = f.loc_id
                  JOIN vaccine va ON va.vac_id = v.vac_id
                  WHERE v.vdate BETWEEN '2021-01-01' AND '2021-07-22'
                  GROUP BY f.province, type_vaccine, v.p_id)AS pop
                  GROUP BY pop.province, pop.type_vaccine
                  ORDER BY pop.province;";

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
          echo "<td>". $type_vaccine ."</td>";
          echo "<td>". $total_num ."</td>";
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