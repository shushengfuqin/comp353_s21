<?php
  include_once '../../config/Database.php';
  $database = new Database();
  $db = $database->connect();


  $query = "INSERT INTO transfer 
            SET
              from_loc = :from_loc,
              to_loc = :to_loc,
              tdate = :tdate,
              vac_id = :vac_id,
              quantity = :quantity;";
          
    //Prepare statement
    $stmt = $db->prepare($query);

    //Bind data 
    $stmt->bindParam(":from_loc", $_POST['from_loc']);
    $stmt->bindParam(":to_loc", $_POST['to_loc']);
    $stmt->bindParam(":tdate", $_POST['tdate']);
    $stmt->bindParam(":vac_id", $_POST['vac_id']);
    $stmt->bindParam(":quantity", $_POST['quantity']);


    try{
        $stmt->execute();
        echo '<script type="text/javascript">
           window.location = "inventory_UI.php"
      </script>';
    }
    catch(Exception $e){
        echo '<h2> Transfer Failed due to: </h2>';
        echo '<p>'. $e->getMessage() .'</p>';
        echo "<form>
        <input type='button' value='Back' onclick='history.go(-1)'>
        </form>";
    }
?>