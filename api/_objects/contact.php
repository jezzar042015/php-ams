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
      $query = 
        "SELECT 
          contactid, 
          firstname, 
          middlename, 
          lastname, 
          title, 
          business_phone, 
          direct_phone, 
          mobile_phone, 
          email1, 
          email2, 
          accountid, 
          notes, 
          created, 
          modified 
        FROM contacts 
        ORDER BY firstname, lastname";  

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
  }
  
  function readOne() {
  
  }

  function read_byAccount() {
    $query = 
      "SELECT 
        contactid, 
        firstname, 
        middlename, 
        lastname, 
        title, 
        business_phone, 
        direct_phone, 
        mobile_phone, 
        email1, 
        email2, 
        accountid, 
        notes, 
        created, 
        modified 
      FROM contacts
      WHERE accountid = :accountid 
      ORDER BY firstname, lastname";  

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':accountid',$this->accountid);
      $stmt->execute();

      return $stmt;  
  }

  function create() {
  
  }
  
  function delete() {
  
  }  
  
  function search($keywords) {
  
  }
  
  
}
?>
