<?php
  include_once '../../config/Database.php';
  $database = new Database();
  $db = $database->connect();


  $query = "INSERT INTO vaccination 
            SET
              p_id = :p_id,
              dose_num = :dose_num,
              emp_id = :emp_id,
              vac_id = :vac_id,
              loc_id = :loc_id,
              vdate = :vdate;";
          
    //Prepare statement
    $stmt = $db->prepare($query);

    //Bind data 
    $stmt->bindParam(":p_id", $_POST['p_id']);
    $stmt->bindParam(":dose_num", $_POST['dose_num']);
    $stmt->bindParam(":emp_id", $_POST['emp_id']);
    $vac_id = '1';
    switch ($_POST['vac_id']) {
        case 'Pfizer-BioNTech':
            $vac_id='1';
            break;
        case 'Moderna':
            $vac_id='2';
            break;
        case 'AstraZeneca':
            $vac_id='3';
            break;
        case 'Johnson & Johnson':
            $vac_id='4';
            break;
        default:
            $vac_id='1';
            break;
    }
    $stmt->bindParam(":vac_id", $vac_id);
    $stmt->bindParam(":loc_id", $_POST['loc_id']);
    $stmt->bindParam(":vdate", $_POST['vdate']);


    try{
        $stmt->execute();
        echo '<script type="text/javascript">
           window.location = "perform.php"
      </script>';
    }
    catch(Exception $e){
        echo '<h2> Vaccination Failed due to: </h2>';
        echo '<p>'. $e->getMessage() .'</p>';
        echo "<form>
        <input type='button' value='Back' onclick='history.go(-1)'>
        </form>";
    }
?>