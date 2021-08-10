<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="../../includes/style.css">
  <title>Person Information</title>
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
  <a href="../../other_query/other_query_UI.php">Other Query</a>
</div>

<div class="main">
<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  // header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Person.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog person object
  $person = new Person($db);

  // Get ID
  $person->p_id = isset($_GET['p_id']) ? $_GET['p_id'] : die();

  // Get person
  $person->readone();

  echo '<h2> Personal Information </h2>';
  echo '<table>';
  echo '<tr>'; 
  echo '<th> Person ID </th>';
  echo '<th> First Name </th>';
  echo '<th> Last Name </th>';
  echo '<th> Date of Birth </th>';
  echo '<th> Phone# </th>';
  echo '<th> Address </th>';
  echo '<th> City </th>';
  echo '<th> Province </th>';
  echo '<th> Postal Code</th>';
  echo '<th> Email </th>';
  echo '<th> Citizenship </th>';
  echo '</tr>';

  echo '<tr>';
  echo '<td>'. $person->p_id .'</td>';
  echo '<td>'. $person->first_name .'</td>';
  echo '<td>'. $person->last_name .'</td>';
  echo '<td>'. $person->dob .'</td>';
  echo '<td>'. $person->phone .'</td>';
  echo '<td>'. $person->address .'</td>';
  echo '<td>'. $person->city .'</td>';
  echo '<td>'. $person->province .'</td>';
  echo '<td>'. $person->postal_code .'</td>';
  echo '<td>'. $person->email .'</td>';
  echo '<td>'. $person->citizenship .'</td> </tr>';
  echo '</table>';

  $person->get_infection();
  echo '<h2> Infection History </h2>';
  if(count($person->infection) > 0){
    echo "<table> <tr>";
    echo "<th> Date </th>";
    echo "<th> Variant Type </th>";
    echo "</tr>";

    foreach($person->infection as $inf){
      echo "<tr>";
      echo "<td>". $inf['idate'] ."</td>";
      echo "<td>". $inf['type'] ."</td>";
      echo "</tr>";
    }
    echo "</table>";

  }
  else{
    echo "<h3 style='color:red'> The selected person has not been infected. </h3>";
  }

?>

<form>
 <input type="button" value="Back" onclick="history.go(-1)">
</form>

</div>
</body>
</html>