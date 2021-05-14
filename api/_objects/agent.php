<?php

class Agent {

    private $conn;
    private $table_name = "agents";

    // object properties
    public $agentID;
    public $isInactive;
    public $lastName;
    public $firstName;
    public $email;
    public $commSplit_new;
    public $commSplit_renew;
    public $brokerFeeSplit;
    public $created;
    public $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    function read() {

        $query = 
            "SELECT 
                agentID, 
                isInactive, 
                lastName, 
                firstName, 
                email, 
                commSplit_new, 
                commSplit_renew, 
                brokerFeeSplit, 
                created, 
                modified 
            FROM agents ORDER BY firstName";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function readOne() {
        $query = 
            "SELECT 
                agentID, 
                isInactive, 
                lastName, 
                firstName, 
                email, 
                commSplit_new, 
                commSplit_renew, 
                brokerFeeSplit, 
                created, 
                modified 
            FROM agents
            WHERE agentid = :agentid 
            ORDER BY firstName";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':agentid', $this->agentid);
        $stmt->execute();

        return $stmt;
    }

    function write() {

    }

    function update() {
        
    }
}

?>