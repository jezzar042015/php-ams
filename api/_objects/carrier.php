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
        
        // create append query
        $query = 
            "INSERT INTO carriers 
            SET
                carriername=:carriername,
                agencycode=:agencycode,
                ambest_rating=:ambest_rating,
                phones=:phones,
                emails=:emails,
                carr_address=:carr_address,
                carr_city=:carr_city,
                carr_state=:carr_state,
                carr_zip=:carr_zip,
                website=:website,
                notes=:notes
            ";

        // prepare query
        $stmt = $this->conn->prepare();

        // sanitize
        $this->carriername=htmlspecialchars(strip_tags($this->carriername));
        $this->agencycode=htmlspecialchars(strip_tags($this->agencycode));
        $this->ambest_rating=htmlspecialchars(strip_tags($this->ambest_rating));
        $this->phones=htmlspecialchars(strip_tags($this->phones));
        $this->emails=htmlspecialchars(strip_tags($this->emails));
        $this->carr_address=htmlspecialchars(strip_tags($this->carr_address));
        $this->carr_city=htmlspecialchars(strip_tags($this->carr_city));
        $this->carr_state=htmlspecialchars(strip_tags($this->carr_state));
        $this->carr_zip=htmlspecialchars(strip_tags($this->carr_zip));
        $this->website=htmlspecialchars(strip_tags($this->website));
        $this->notes=htmlspecialchars(strip_tags($this->notes));

        // bind values
        $stmt->bindParam(":carriername", $this->carriername);
        $stmt->bindParam(":agencycode", $this->agencycode);
        $stmt->bindParam(":ambest_rating", $this->ambest_rating);
        $stmt->bindParam(":phones", $this->phones);
        $stmt->bindParam(":emails", $this->emails);
        $stmt->bindParam(":carr_address", $this->carr_address);
        $stmt->bindParam(":carr_city", $this->carr_city);
        $stmt->bindParam(":carr_state", $this->carr_state);
        $stmt->bindParam(":carr_zip", $this->carr_zip);
        $stmt->bindParam(":website", $this->website);
        $stmt->bindParam(":notes", $this->notes);

        // execute query
        if ($stmt->execute()) {
            return array(
                "message"=> "Insert successful",
                "carrierid" => $this->conn->lastInsertId(),
                "carriername" => $this->carriername,
                "status" => 200
            );
        }

        return array(
            "message"=> "Insert failed",
            "carriername" => $this->carriername,
            "status" => 400
        );
    }

    function update() {

    }

    function search() {

    }
}
?>
