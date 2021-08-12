<?php
    class Vaccine  {
        //DB stuff
        private $conn;
        private $table = 'vaccine';

        //vaccine Properties
        public $vac_id;
        public $name;
        public $vac_desc;
        public $status;
        

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all vaccine
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        

        //get one vaccine
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE vac_id = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->vac_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->vac_id = $row['vac_id'];
          $this->name = $row['name'];
          $this->vac_desc = $row['vac_desc'];
          $this->status = $row['status'];
          

        }

        //create vaccine
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              vac_id = :vac_id,
              name = :name,
              vac_desc = :vac_desc
              status = :status';
              
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          
          $stmt->bindParam(":vac_id", $this->vac_id);
          $stmt->bindParam(":name", $this->name);
          $stmt->bindParam(":vac_desc", $this->vac_desc);
          $stmt->bindParam(":status", $this->status);



          //Execute query
          if($stmt->execute()){
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
        }
        


        //update vaccine 
        public function update(){
          //Create query
          $query = 'UPDATE ' .
          $this->table . ' 
        SET
            vac_id = :vac_id,
             name = :name,
              vac_desc = :vac_desc
              status = :status';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":vac_id", $this->vac_id);
          $stmt->bindParam(":name", $this->name);
          $stmt->bindParam(":vac_desc", $this->vac_desc);
          $stmt->bindParam(":status", $this->status);
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete vaccine 还有问题
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE vac_id = :vac_id';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind data 
      $stmt->bindParam(":vac_id", $this->vac_id);

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
