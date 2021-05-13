<?php

class Agent() {

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

    }

    function write() {

    }

    function update() {
        
    }
}

?>