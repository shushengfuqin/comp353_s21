<?php
    class Vaccination {
        //DB stuff
        private $conn;
        private $table = 'vaccination';

        //vaccination Properties
        public $p_id;
        public $dose_num;
        public $emp_id;
        public $vac_id;
        public $loc_id;
        public $vdate;
        
        // added a infection history here
        public $infection;


        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all vaccnations
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // function for get infection history
        public function get_infection(){
            // create query for infection history
            $query = "SELECT idate, variant_name FROM infection JOIN variant_type ON (type=variant_id) WHERE p_id=?"; 
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->p_id);
            $stmt->execute();

            $this->infection = array();
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'idate' => $row['idate'],
                    'type' => $row['variant_name']
                );
                array_push($this->infection, $item);
            }
        }

        //get one vaccination
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE p_id = ? AND dose_num = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->p_id);
          $stmt->bindParam(2, $this->dose_num);
          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->p_id = $row['p_id'];
          $this->dose_num = $row['dose_num'];
          $this->emp_id = $row['emp_id'];
          $this->vac_id = $row['vac_id'];
          $this->loc_id = $row['loc_id'];
          $this->vdate = $row['vdate'];
          

        }

        //create vaccination
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              p_id = :p_id,
              dose_num = :dose_num,
              emp_id = :emp_id,
              vac_id = :vac_id,
              loc_id = :loc_id,
              vdate = :vdate';
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          // $stmt->bindParam(":p_id", $this->p_id);
          $stmt->bindParam(":p_id", $this->p_id);
          $stmt->bindParam(":dose_num", $this->dose_num);
          $stmt->bindParam(":emp_id", $this->emp_id);
          $stmt->bindParam(":vac_id", $this->vac_id);
          $stmt->bindParam(":loc_id", $this->loc_id);
          $stmt->bindParam(":vdate", $this->vdate);
          

          //Execute query
          if($stmt->execute()){
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
        }
        


        //update vaccination 
        public function update(){
          //Create query
          $query = 'UPDATE ' .
          $this->table . ' 
        SET
          p_id = :p_id,
              dose_num = :dose_num,
              emp_id = :emp_id,
              vac_id = :vac_id,
              loc_id = :loc_id,
              vdate = :vdate';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":p_id", $this->p_id);
          $stmt->bindParam(":dose_num", $this->dose_num);
          $stmt->bindParam(":emp_id", $this->emp_id);
          $stmt->bindParam(":vac_id", $this->vac_id);
          $stmt->bindParam(":loc_id", $this->loc_id);
          $stmt->bindParam(":vdate", $this->vdate);
          
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete vaccination 还有问题
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE p_id = :p_id AND dose_num = :dose_num';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind data 
      $stmt->bindParam(":p_id", $this->p_id);
      $stmt->bindParam(":dose_num", $this->dose_num);

      // Execute query
      try{
        $stmt->execute();
      }
      catch (Exception $e){
        return false;
      }
      return true;

    }
}
