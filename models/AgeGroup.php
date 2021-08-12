<?php
    class AgeGroup  {
        //DB stuff
        private $conn;
        private $table = 'age_group';

        //worker Properties
        public $grp_id;
        public $upper_limit;
        public $lower_limit;
        
        

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all age groups
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        

        //get one age group
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE grp_id = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->grp_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->grp_id = $row['grp_id'];
          $this->upper_limit = $row['upper_limit'];
          $this->lower_limit = $row['lower_limit'];
          

        }

        //create age group
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              grp_id = :grp_id,
              upper_limit = :upper_limit;
              lower_limit = :lower_limit';
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          
          $stmt->bindParam(":grp_id", $this->grp_id);
          $stmt->bindParam(":upper_limit", $this->upper_limit);
          $stmt->bindParam(":lower_limit", $this->lower_limit);

          //Execute query
          if($stmt->execute()){
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
        }
        


        //update age group 
        public function update(){
          //Create query
          $query = 'UPDATE ' .
          $this->table . ' 
        SET
            grp_id = :grp_id,
              upper_limit = :upper_limit;
              lower_limit = :lower_limit';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":grp_id", $this->grp_id);
          $stmt->bindParam(":upper_limit", $this->upper_limit);
          $stmt->bindParam(":lower_limit", $this->lower_limit);
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete age group 还有问题
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE grp_id = :grp_id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind data 
      $stmt->bindParam(":grp_id", $this->grp_id);

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
