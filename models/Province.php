<?php
    class Province  {
        //DB stuff
        private $conn;
        private $table = 'pv_age';

        //worker Properties
        public $province;
        public $grp_id;
        
        
        

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all province
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        

        //get one province
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE province = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->province);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->province = $row['province'];
          $this->grp_id = $row['grp_id'];
          
          

        }

        //create province
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              province = :province,
              grp_id = :grp_id';
              
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          
          $stmt->bindParam(":province", $this->province);
          $stmt->bindParam(":grp_id", $this->grp_id);
          

          //Execute query
          if($stmt->execute()){
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
        }
        


        //update province 
        public function update(){
          //Create query
          $query = 'UPDATE ' .
          $this->table . ' 
        SET
            province = :province,
              grp_id = :grp_id';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":province", $this->province);
          $stmt->bindParam(":grp_id", $this->grp_id);
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete province 还有问题
    public function delete(){
      //Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE province = :province';

      //Prepare statement
      $stmt = $this->conn->prepare($query);

      //Bind data 
      $stmt->bindParam(":province", $this->province);

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
