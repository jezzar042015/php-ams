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
  public $terminatedate;
  public $dob;
  public $cdl_state;
  public $cdl_number;
  public $years_licensed;
  public $phone;
  public $email;
  public $accountid;
  public $created;
  public $modified;
  public $policies;
  
  //object functions
  public function __construct($db) {
    $this->conn = $db;
  }
  
  
}

?>
