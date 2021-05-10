<?php 

class Carrier {


    private $conn;
    private $table_name = "carriers";

    //properties
    public $carrierid;
    public $carriername;
    public $agencycode;
    public $ambest_rating;
    public $phones;
    public $emails;
    public $carr_address;
    public $carr_city;
    public $carr_state;
    public $carr_zip;
    public $website;
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
