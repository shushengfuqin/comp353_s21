<?php
    class Facility  {
        //DB stuff
        private $conn;
        private $table = 'facility';

        //Person Properties
        public $loc_id;
        public $name;
        public $address;
        public $city;
        public $province;
        public $postal_code;
        public $phone;
        public $web;
        public $type;
        public $manager;
        
        

        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all facility
        public function read(){
            //create query
            $query = 'SELECT * FROM ' . $this->table .'';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        

        //get one facility
        public function readone(){
            //create query
          $query = 'SELECT * FROM ' . $this->table .' WHERE loc_id = ? LIMIT 0,1';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(1, $this->loc_id);

          // Execute query
          $stmt->execute();

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          // Set properties
          $this->name = $row['name'];
          $this->address = $row['address'];
          $this->city = $row['city'];
          $this->province = $row['province'];
          $this->postal_code = $row['postal_code'];
          $this->phone = $row['phone'];
          $this->web = $row['web'];
          $this->type = $row['type'];
          $this->manager = $row['manager'];
          

        }

        //create facility
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              name = :name,
              address = :address,
              city = :city,
              province = :province,
              postal_code = :postal_code,
              phone = :phone,
              web = :web,
              type = :type,
              manager = :manager';
              
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          
          $stmt->bindParam(":name", $this->name);
          $stmt->bindParam(":address", $this->address);
          $stmt->bindParam(":city", $this->city);
          $stmt->bindParam(":province", $this->province);
          $stmt->bindParam(":postal_code", $this->postal_code);
          $stmt->bindParam(":phone", $this->phone);
          $stmt->bindParam(":web", $this->web);
          $stmt->bindParam(":type", $this->type);
          $stmt->bindParam(":manager", $this->manager);

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
            name = :name,
            address = :address,
            city = :city,
            province = :province,
            postal_code = :postal_code,
            phone = :phone,
            web = :web,
            type = :type,
            manager = :manager';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":name", $this->name);
          $stmt->bindParam(":address", $this->address);
          $stmt->bindParam(":city", $this->city);
          $stmt->bindParam(":province", $this->province);
          $stmt->bindParam(":postal_code", $this->postal_code);
          $stmt->bindParam(":phone", $this->phone);
          $stmt->bindParam(":web", $this->web);
          $stmt->bindParam(":type", $this->type);
          $stmt->bindParam(":manager", $this->manager);
          
          //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;

    }
    
        //delete person 还有问题
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
