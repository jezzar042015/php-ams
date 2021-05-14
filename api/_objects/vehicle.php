<?php
class Vehicle {
  
  private $conn;
  private $table_name = "vehicles";
  
  //object properties
  public $vehicleID;
  public $vin;
  public $year;
  public $makeid;
  public $makename;
  public $typeid;
  public $typename;
  public $model;
  public $unit_number;
  public $pdvalue;
  public $driverid;
  public $drivername;
  public $lienholder;
  public $lienholdername;
  public $accountid;
  public $legalname;
  public $created;
  public $modified;
  
  public function __construct($db) {
    $this->conn = $db;
  }
  
  function read() {
      $query = 
          "SELECT 
              vehicleid, 
              vin, 
              vehicle_year, 
              makeid, 
              typeid, 
              model, 
              unit_number, 
              pdvalue, 
              driverid, 
              lienholder, 
              accountid, 
              notes, 
              created, 
              modified 
            FROM vehicles ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;

  }

  function read_byAccount() {
    $query = 
        "SELECT 
            vehicleid, 
            vin, 
            vehicle_year, 
            makeid, 
            typeid, 
            model, 
            unit_number, 
            pdvalue, 
            driverid, 
            lienholder, 
            accountid, 
            notes, 
            created, 
            modified  
        FROM vehicles 
        WHERE accountid = :accountid";

  $stmt = $this->conn->prepare($query);
  $stmt->bindParam(':accountid',$this->accountid);  
  $stmt->execute();

  return $stmt;    
  }

}
?>
