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
        // create query
        $query = 
            "SELECT
                mgaid,
                mganame,
                writingstate,
                carriers,
                phones,
                emails,
                mga_address,
                mga_city,
                (SELECT city FROM usstates WHERE id = mga_city) AS mga_cityname,
                mga_state,
                mga_zip,
                website,
                endtFees,
                notes,
                created,
                modified            
            FROM mgas
            ORDER BY mganame;"

        // prepare query
        $stmt = $this->conn->prepare();

        // execute query
        $stmt->execute();

        //return results
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
