<?php
  include_once '../../config/Database.php';
  $database = new Database();
  $db = $database->connect();


  $query = "INSERT INTO shipment 
            SET
              loc_id = :loc_id,
              sdate = :sdate,
              vac_id = :vac_id,
              quantity = :quantity;";
          
    //Prepare statement
    $stmt = $db->prepare($query);

    //Bind data 
    $stmt->bindParam(":loc_id", $_POST['loc_id']);
    $stmt->bindParam(":sdate", $_POST['sdate']);
    $stmt->bindParam(":vac_id", $_POST['vac_id']);
    $stmt->bindParam(":quantity", $_POST['quantity']);


    try{
        $stmt->execute();
        echo '<script type="text/javascript">
           window.location = "inventory_UI.php"
      </script>';
    }
    catch(Exception $e){
        echo '<h2> Shipment Failed due to: </h2>';
        echo '<p>'. $e->getMessage() .'</p>';
        echo "<form>
        <input type='button' value='Back' onclick='history.go(-1)'>
        </form>";
    }
?>