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
        // create append query
        $query = 
            "INSERT INTO mgas 
            SET
                mganame=:mganame,
                writingstate=:writingstate,
                carriers=:carriers,
                phones=:phones,
                emails=:emails,
                mga_address=:mga_address,
                mga_city=:mga_city,
                mga_state=:mga_state,
                mga_zip=:mga_zip,
                website=:website,
                endtFees=:endtFees,
                notes=:notes
            ";

        // prepare query
        $stmt = $this->conn->prepare();

        // sanitize
        $this->mganame=htmlspecialchars(strip_tags($this->mganame));
        $this->writingstate=htmlspecialchars(strip_tags($this->writingstate));
        $this->carriers=htmlspecialchars(strip_tags($this->carriers));
        $this->phones=htmlspecialchars(strip_tags($this->phones));
        $this->emails=htmlspecialchars(strip_tags($this->emails));
        $this->mga_address=htmlspecialchars(strip_tags($this->mga_address));
        $this->mga_city=htmlspecialchars(strip_tags($this->mga_city));
        $this->mga_state=htmlspecialchars(strip_tags($this->mga_state));
        $this->mga_zip=htmlspecialchars(strip_tags($this->mga_zip));
        $this->website=htmlspecialchars(strip_tags($this->website));
        $this->endtFees=htmlspecialchars(strip_tags($this->endtFees));
        $this->notes=htmlspecialchars(strip_tags($this->notes));

        // bind values
        $stmt->bindParam(":mganame", $this->mganame);
        $stmt->bindParam(":writingstate", $this->writingstate);
        $stmt->bindParam(":carriers", $this->carriers);
        $stmt->bindParam(":phones", $this->phones);
        $stmt->bindParam(":emails", $this->emails);
        $stmt->bindParam(":mga_address", $this->mga_address);
        $stmt->bindParam(":mga_city", $this->mga_city);
        $stmt->bindParam(":mga_state", $this->mga_state);
        $stmt->bindParam(":mga_zip", $this->mga_zip);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":endtFees", $this->endtFees);
        $stmt->bindParam(":notes", $this->notes);

        // execute query
        if ($stmt->execute()) {
            return array(
                "message"=> "Insert successful",
                "mgaid" => $this->conn->lastInsertId(),
                "mganame" => $this->mganame,
                "status" => 200;
            );
        }

        return array(
            "message"=> "Insert failed",
            "mganame" => $this->mganame,
            "status" => 400;
        );

    }

    function update() {

    }

    function search() {
        
    }
}
?>
