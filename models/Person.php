<?php
    class Person {
        //DB stuff
        private $conn;
        private $table = 'person';

        //Person Properties
        public $p_id;
        public $first_name;
        public $last_name;
        public $dob;
        public $phone;
        public $address;
        public $city;
        public $province;
        public $postal_code;
        public $email;
        public $citizenship;
        // added a infection history here
        public $infection;


        //Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
          }

        //get all person
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

        //get one person
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
          $this->first_name = $row['first_name'];
          $this->last_name = $row['last_name'];
          $this->dob = $row['dob'];
          $this->phone = $row['phone'];
          $this->address = $row['address'];
          $this->city = $row['city'];
          $this->province = $row['province'];
          $this->postal_code = $row['postal_code'];
          $this->email = $row['email'];
          $this->citizen = $row['citizenship'];

        }

        //create person
        public function create(){
                //Create query
              $query = 'INSERT INTO ' .
              $this->table . ' 
            SET
              
              first_name = :first_name,
              last_name = :last_name,
              dob = :dob,
              phone = :phone,
              address = :address,
              city = :city,
              province = :province,
              postal_code = :postal_code,
              email = :email,
              citizenship =:citizenship';
          
          //Prepare statement
          $stmt = $this->conn->prepare($query);

          //Bind data 
          // $stmt->bindParam(":p_id", $this->p_id);
          $stmt->bindParam(":first_name", $this->first_name);
          $stmt->bindParam(":last_name", $this->last_name);
          $stmt->bindParam(":dob", $this->dob);
          $stmt->bindParam(":phone", $this->phone);
          $stmt->bindParam(":address", $this->address);
          $stmt->bindParam(":city", $this->city);
          $stmt->bindParam(":province", $this->province);
          $stmt->bindParam(":postal_code", $this->postal_code);
          $stmt->bindParam(":email", $this->email);
          $stmt->bindParam(":citizenship", $this->citizenship);

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
          first_name = :first_name,
          last_name = :last_name,
          dob = :dob,
          phone = :phone,
          address = :address,
          city = :city,
          province = :province,
          postal_code = :postal_code,
          email = :email
          WHERE p_id = :p_id';
  
  //Prepare statement
          $stmt = $this->conn->prepare($query);

    //Bind data 
          $stmt->bindParam(":first_name", $this->first_name);
          $stmt->bindParam(":last_name", $this->last_name);
          $stmt->bindParam(":dob", $this->dob);
          $stmt->bindParam(":phone", $this->phone);
          $stmt->bindParam(":address", $this->address);
          $stmt->bindParam(":city", $this->city);
          $stmt->bindParam(":province", $this->province);
          $stmt->bindParam(":postal_code", $this->postal_code);
          $stmt->bindParam(":email", $this->email);
          $stmt->bindParam(":p_id", $this->p_id);
          
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

      //Execute query
      if($stmt->execute()){
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
          }
        }
