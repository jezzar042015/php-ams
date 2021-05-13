<?php

class Driver {
  
  private $conn;
  private $table_name = "drivers";
  
  // object properties
  public $driverid;
  public $firstname;
  public $middlename;
  public $lastname;
  public $hiredate;
  public $terminationdate;
  public $dob;
  public $cdl_state;
  public $cdl_number;
  public $year_licensed;
  public $phone;
  public $email;
  public $accountid;
  public $legalname;
  public $created;
  public $modified;
  public $policies;
  
  //object functions
  public function __construct($db) {
    $this->conn = $db;
  }
  
  function read() {
  
  }
  
  function write() {
      //creating query
      $query = 
        "INSERT INTO drivers 
        SET
          firstname=:firstname,
          middlename=:middlename,
          lastname=:lastname,
          hiredate=:hiredate,
          terminationdate=:terminationdate,
          dob=:dob,
          cdl_state=:cdl_state,
          cdl_number=:cdl_number,
          year_licensed=:year_licensed,
          phone=:phone;
          email=:email;
          accountid=:accountid,
          created=:created
        ";
    
      //prepare query
      $stmt = $this->conn->prepare($query);
    
      //sanitize data
      $this->firstname = htmlspecialchars(strip_tags($this->firstname));
      $this->middlename = htmlspecialchars(strip_tags($this->middlename));
      $this->lastname = htmlspecialchars(strip_tags($this->lastname));
      $this->hiredate = htmlspecialchars(strip_tags($this->hiredate));
      $this->terminationdate = htmlspecialchars(strip_tags($this->terminationdate));
      $this->dob = htmlspecialchars(strip_tags($this->dob));
      $this->cdl_state = htmlspecialchars(strip_tags($this->cdl_state));
      $this->cdl_number = htmlspecialchars(strip_tags($this->cdl_number));
      $this->year_licensed = htmlspecialchars(strip_tags($this->year_licensed));
      $this->phone = htmlspecialchars(strip_tags($this->phone));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->accountid = htmlspecialchars(strip_tags($this->accountid));
    
      //binding values
      $stmt->bindParam(":firstname",$this->firstname);
      $stmt->bindParam(":middlename",$this->middlename);
      $stmt->bindParam(":lastname",$this->lastname);
      $stmt->bindParam(":hiredate",$this->hiredate);
      $stmt->bindParam(":terminationdate",$this->terminationdate);
      $stmt->bindParam(":dob",$this->dob);
      $stmt->bindParam(":cdl_state",$this->cdl_state);
      $stmt->bindParam(":cdl_number",$this->cdl_number);
      $stmt->bindParam(":year_licensed",$this->year_licensed);
      $stmt->bindParam(":phone",$this->phone);
      $stmt->bindParam(":email",$this->email);
      $stmt->bindParam(":accountid",$this->accountid);
      $stmt->bindParam(":created",$this->created);
    
      //execute query
      if ($stmt->execute()) {
          return array(
              "message"=>"Driver was added successfully",
              "drivername"=>$this->firstname . " " . $this->lastname,
              "driverid"=>$this->driverid,
              "status"=>"200"
          )
      }
      else {
          return array(
              "message"=>"Driver insert was failed",
              "drivername"=>$this->firstname . " " . $this->lastname,
              "status"=>"400"
        
      }  
  }
            
  
  function search() {
  
  }
  
}

?>
