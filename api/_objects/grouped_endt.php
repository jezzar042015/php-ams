<?php

class GroupEndt {

    private $conn;


    public $effective;
    public $action_name;
    public $endt_description;
    public $vehicle_year;
    public $makename;
    public $vin;
    public $pdvalue;
    public $surcharge;
    public $al_premium;
    public $mtc_premium;
    public $pd_premium;
    public $brokerfees;
    public $endtfees;
    public $otherfees;
    public $totalpremium;
    public $al_status;
    public $mtc_status;
    public $pd_status;
    public $accountid;

    public function __construct($db) {
        $this->conn = $db;
    }

    function read() {
        $query = "CALL GetAccountGroupedEndorsements (?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->accountid,PDO::PARAM_STR, 4000);
        
        $stmt->execute();
        return $stmt;


    }


}
?>