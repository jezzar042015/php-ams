<?php 

class MGA {


    private $conn;
    private $table_name = "mgas";

    //properties
    public $mgaid;
    public $mganame;
    public $writingstate;
    public $carriers;
    public $phones;
    public $emails;
    public $mga_address;
    public $mga_city;
    public $mga_cityname;
    public $mga_state;
    public $mga_zip;
    public $website;
    public $endtFees;
    public $notes;
    public $created;
    public $modified;


    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read() {

    }

    function create() {

    }

    function update() {

    }

    function search() {
        
    }
}
?>
