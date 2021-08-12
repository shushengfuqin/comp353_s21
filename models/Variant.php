<?php
    class Variant  {
        //DB stuff
        private $conn;
        private $table = 'variant_type';

        //worker Properties
        public $variant_id;
        public $variant_name;
        
        
        

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all variants
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        

        //get one variant
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE variant_id = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->variant_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->variant_id = $row['variant_id'];
          $this->variant_name = $row['variant_name'];
          
          

        }

        //create facility
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              variant_id = :variant_id,
              variant_name = :variant_name';
              
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          
          $stmt->bindParam(":variant_id", $this->variant_id);
          $stmt->bindParam(":variant_name", $this->variant_name);
          

          //Execute query
          if($stmt->execute()){
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
        }
        


        //update variant 
        public function update(){
          //Create query
          $query = 'UPDATE ' .
          $this->table . ' 
        SET
            variant_id = :variant_id,
              variant_name = :variant_name';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":variant_id", $this->variant_id);
          $stmt->bindParam(":variant_name", $this->variant_name);
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete variant 还有问题
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE variant_id = :variant_id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind data 
      $stmt->bindParam(":variant_id", $this->variant_id);

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
