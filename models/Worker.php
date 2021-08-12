<?php
    class Worker  {
        //DB stuff
        private $conn;
        private $table = 'health_worker';

        //worker Properties
        public $p_id;
        public $emp_id;
        
        
        

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all works
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        

        //get one worker
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE p_id = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->p_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->p_id = $row['p_id'];
          $this->emp_id = $row['emp_id'];
          
          

        }

        //create facility
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              p_id = :p_id,
              emp_id = :emp_id';
              
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          
          $stmt->bindParam(":p_id", $this->p_id);
          $stmt->bindParam(":emp_id", $this->emp_id);
          

          //Execute query
          if($stmt->execute()){
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
        }
        


        //update person 
        public function update(){
          //Create query
          $query = 'UPDATE ' .
          $this->table . ' 
        SET
            p_id = :p_id,
              emp_id = :emp_id';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":p_id", $this->p_id);
          $stmt->bindParam(":emp_id", $this->emp_id);
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete worker 还有问题
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE p_id = :p_id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind data 
      $stmt->bindParam(":p_id", $this->p_id);

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
