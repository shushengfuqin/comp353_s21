<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../includes/style.css">
  <title>Query 19</title>
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

    <h3> (19) Give a list of all public health workers in a specific facility (EmployeeID, Social Security Number (SSN), first-name, last-name, date of birth, medicare card number, telephone-number, address, city, province, postal-code, citizenship, email address, and history of employment).</h3>

    <?php
        include_once '../config/Database.php';
        $database = new Database();
        $db = $database->connect();

        // prepare query
        $query = "SELECT hw.emp_id, c.ssn, p.first_name, p.last_name, p.dob, c.medicare, p.phone, p.address, p.city, p.province, p.postal_code, p.citizenship, p.email, wh.start_date, wh.end_date
          FROM health_worker hw
          JOIN person p ON p.p_id = hw.p_id
          JOIN citizen c ON hw.p_id = c.p_id 
          JOIN work_history wh ON hw.emp_id = wh.emp_id         
          JOIN facility f ON wh.loc_id = f.loc_id
          WHERE f.loc_id = ? ;";
        // Get ID
        $loc_id = isset($_GET['loc_id']) ? $_GET['loc_id'] : die();

        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $loc_id);

        // Execute query
        $stmt->execute();

        // table header
        echo "<table><tr>";
        echo "<th> Employee ID </th>";
        echo "<th> SSN </th>";
        echo "<th> First Name </th>";
        echo "<th> Last Name </th>";
        echo "<th> Date of Birth </th>";
        echo "<th> Medicare # </th>";
        echo "<th> Phone # </th>";
        echo "<th> Address </th>";
        echo "<th> City </th>";
        echo "<th> Province </th>";
        echo "<th> Postal Code </th>";
        echo "<th> Citizenship </th>";
        echo "<th> Email </th>";
        echo "<th> Start Date </th>";
        echo "<th> End Date </th> </tr>";

        // extract data from stmt
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          echo "<tr>";
          echo "<td>". $emp_id ."</td>";
          echo "<td>". $ssn ."</td>";
          echo "<td>". $first_name ."</td>";
          echo "<td>". $last_name ."</td>";
          echo "<td>". $dob ."</td>";
          echo "<td>". $medicare ."</td>";
          echo "<td>". $phone ."</td>";
          echo "<td>". $address ."</td>";
          echo "<td>". $city ."</td>";
          echo "<td>". $province ."</td>";
          echo "<td>". $postal_code ."</td>";
          echo "<td>". $citizenship ."</td>";
          echo "<td>". $email ."</td>";
          echo "<td>". $start_date ."</td>";
          echo "<td>". $end_date ."</td>";
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