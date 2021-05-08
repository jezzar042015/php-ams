<?php
class Account{
  
    // database connection and table name
    private $conn;
    private $table_name = "accounts";
  
    // object properties
    public $accountid;
    public $accountStatus;
    public $accountStatus_name;
    public $accountType;
    public $accountType_name;
    public $usdot;
    public $statePermit;
    public $taxid;
    public $legalname;
    public $dba;
    public $operation;
    public $operation_name;
    public $radius;
    public $radius_name;
    public $mailAddress;
    public $mailCity;
    public $mailCity_name;
    public $mailState;
    public $mailZip;
    public $garageAddress;
    public $garageCity;
    public $garageCity_name;
    public $garageState;
    public $garageZip;
    public $notes;
    public $accountSource;
    public $source_name;
    public $yearClient;
    public $agent;
    public $agent_name;
    public $created;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    function read(){
  
        // select all query
        $query = "SELECT 
                    accountid, 
                    accountStatus,
                    accountStatus.account_status AS accountStatus_name,
                    accountType,
                    accountTypes.account_type AS accountType_name,
                    usdot,
                    statePermit,
                    taxid,
                    legalname,
                    dba,
                    accounts.operation,
                    operations.operation AS operation_name,
                    accounts.radius,
                    radius.radius AS radius_name,
                    mailAddress,
                    mailCity,
                    (SELECT city FROM usstates WHERE id = mailCity LIMIT 1) AS mailCity_name,
                    mailState,
                    mailZip,
                    garageAddress,
                    garageCity,
                    (SELECT city FROM usstates WHERE id = garageCity LIMIT 1) AS garageCity_name,
                    garageState,
                    garageZip,
                    notes,
                    accounts.accountSource,
                    accountSources.accountSource AS source_name,
                    yearClient,
                    agent,
                    CONCAT(agents.firstName,' ',agents.lastName) AS agent_name,
                    accounts.created

                    FROM agents 
                        RIGHT JOIN (((((accountTypes 
                            RIGHT JOIN (accountStatus 
                                RIGHT JOIN accounts ON accountStatus.id = accounts.accountStatus) 
                                    ON accountTypes.id = accounts.accountType) 
                        LEFT JOIN accountSources ON accounts.accountSource = accountSources.id) 
                        LEFT JOIN operations ON accounts.operation = operations.id) 
                        LEFT JOIN radius ON accounts.radius = radius.id) 
                        LEFT JOIN usstates ON (accounts.mailCity = usstates.id) AND (accounts.garageCity = usstates.id)) 
                            ON agents.agentID = accounts.agent	
        ORDER BY legalname";
      
        // prepare query statement
        $stmt = $this->conn->prepare($query);
      
        // execute query
        $stmt->execute();
      
        return $stmt;
    }
    
    function create() {
        // query to insert record
        $query = "INSERT INTO accounts
                SET
                    legalname=:legalname, 
                    accountStatus=:accountStatus, 
                    accountType=:accountType,
                    usdot=:usdot,
                    statePermit=:statePermit,
                    taxid=:taxid,
                    dba=:dba,
                    operation=:operation,
                    radius=:radius,
                    mailAddress=:mailAddress,
                    mailCity=:mailCity,
                    mailState=:mailState,
                    mailZip=:mailZip,
                    garageAddress=:garageAddress,
                    garageCity=:garageCity,
                    garageState=:garageState,
                    garageZip=:garageZip,
                    notes=:notes,
                    accountSource=:accountSource,
                    yearClient=:yearClient,
                    agent=:agent,
                    created=:created
                ";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        // $this->name=htmlspecialchars(strip_tags($this->name));
        // $this->price=htmlspecialchars(strip_tags($this->price));
        // $this->description=htmlspecialchars(strip_tags($this->description));
        // $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        // $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":legalname", $this->legalname);
        $stmt->bindParam(":accountStatus", $this->accountStatus);
        $stmt->bindParam(":accountType", $this->accountType);
        $stmt->bindParam(":usdot", $this->usdot);
        $stmt->bindParam(":statePermit", $this->statePermit);
        $stmt->bindParam(":taxid", $this->taxid);
        $stmt->bindParam(":dba", $this->dba);
        $stmt->bindParam(":operation", $this->operation);
        $stmt->bindParam(":radius", $this->radius);
        $stmt->bindParam(":mailAddress", $this->mailAddress);
        $stmt->bindParam(":mailCity", $this->mailCity);
        $stmt->bindParam(":mailState", $this->mailState);
        $stmt->bindParam(":mailZip", $this->mailZip);
        $stmt->bindParam(":garageAddress", $this->garageAddress);
        $stmt->bindParam(":garageCity", $this->garageCity);
        $stmt->bindParam(":garageState", $this->garageState);
        $stmt->bindParam(":garageZip", $this->garageZip);
        $stmt->bindParam(":notes", $this->notes);
        $stmt->bindParam(":accountSource", $this->accountSource);
        $stmt->bindParam(":yearClient", $this->yearClient);
        $stmt->bindParam(":agent", $this->agent);
        $stmt->bindParam(":created", $this->created);

        // execute query
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        }
    
        return 0;        
    }

}

?>