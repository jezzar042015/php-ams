<?php
class Contact {
    
  //database connection and table name
  private $conn;
  private $table_name = "contacts";
  
  //object properties
  public $contactid;
  public $firstname;
  public $middlename;
  public $lastname;
  public $title;
  public $mobile_phone;
  public $business_phone;
  public $email1;
  public $email2;
  public $company_type;
  public $company_ref;
  
  public $created;
  public $modified;
  
  public function __construct($db) {
    $this->conn = $db;
  }
  
  function read() {
  
  }
  
  function create() {
  
  }
  
  function delete() {
  
  }  
  
  function search($keywords) {
  
  }
  
  
}
?>
