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
        // create query
        $query = 
            "SELECT
                carrierid,
                carriername,
                agencycode,
                ambest_rating,
                phones,
                emails,
                carr_address,
                carr_city,
                (SELECT city FROM usstates WHERE id = carr_city) AS carr_cityname,
                carr_state,
                carr_zip,
                website,
                notes,
                created,
                modified                
            FROM carriers
            ORDER BY carriername";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        //return result
        return $stmt;
    }

    function create() {

    }

    function update() {

    }

    function search() {

    }
}
?>
