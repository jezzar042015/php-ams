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
              v.makeid, 
              makename,
              v.typeid,
              typename, 
              model, 
              unit_number, 
              pdvalue, 
              v.driverid, 
              CONCAT(d.firstname,' ',d.lastname) AS drivername, 
              lienholder, 
              v.accountid, 
              notes, 
              created, 
              modified 
              FROM ((vehicles AS v 
                  LEFT JOIN vehiclemakes AS m ON v.makeid = m.makeid)
                  LEFT JOIN vehicletypes AS t ON v.typeid = t.typeid)
                  LEFT JOIN drivers AS d ON v.driverid = d.driverid  
            ORDER BY v.typeid";

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
            v.makeid,
            makename, 
            v.typeid,
            typename, 
            model, 
            unit_number, 
            pdvalue, 
            v.driverid, 
            CONCAT(d.firstname,' ',d.lastname) AS drivername, 
            lienholder, 
            v.accountid, 
            v.notes, 
            v.created, 
            v.modified  
        FROM ((vehicles AS v 
            LEFT JOIN vehiclemakes AS m ON v.makeid = m.makeid)
            LEFT JOIN vehicletypes AS t ON v.typeid = t.typeid)
            LEFT JOIN drivers AS d ON v.driverid = d.driverid
        WHERE v.accountid = :accountid
        ORDER BY v.typeid, makename";

  $stmt = $this->conn->prepare($query);
  $stmt->bindParam(':accountid',$this->accountid);  
  $stmt->execute();

  return $stmt;    
  }

}
?>
