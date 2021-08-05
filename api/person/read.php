<!DOCTYPE HTML>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  /*width: 100%;*/
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

  <h1> Detailed Description of All Person </h1>
  <table>
    <tr> 
      <th> Person ID </th>
      <th> First Name </th>
      <th> Last Name </th>
      <th> Date of Birth </th>
      <th> Phone# </th>
      <th> Address </th>
      <th> City </th>
      <th> Province </th>
      <th> Postal Code</th>
      <th> email </th> 
    </tr>
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

  // Blog person query
  $result = $person->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any persons
  if($num > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      // $person_item = array(
      //   'p_id' => $p_id,
      //   'first name' => $first_name,
      //   'last name' => $last_name,
      //   'date of birth' => $dob,
      //   'phone' => $phone,
      //   'address' => $address,
      //   'city' => $city,
      //   'province' => $province,
      //   'postal code' => $postal_code,
      //   'E-Mail' => $email
      // );
      echo '<tr>';
      echo '<td>'. $p_id .'<td/>';
      echo '<td>'. $first_name .'<td/>';
      echo '<td>'. $last_name .'<td/>';
      echo '<td>'. $dob .'<td/>';
      echo '<td>'. $phone .'<td/>';
      echo '<td>'. $address .'<td/>';
      echo '<td>'. $city .'<td/>';
      echo '<td>'. $province .'<td/>';
      echo '<td>'. $postal_code .'<td/>';
      echo '<td>'. $email .'<td/>';
      echo '</tr>';
    }

  } 
  else {

  }
?>

  </table>

</body>
</html>