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
    public $authority;
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
    
    public $contacts;
    public $policies;
    public $drivers;
    public $vehicles;
    public $endorsements;
  
  
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
                    authority,
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
    
    function write() {
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
        $this->legalname=htmlspecialchars(strip_tags($this->legalname));
        $this->accountStatus=htmlspecialchars(strip_tags($this->accountStatus));
        $this->accountType=htmlspecialchars(strip_tags($this->accountType));
        $this->usdot=htmlspecialchars(strip_tags($this->usdot));
        $this->statePermit=htmlspecialchars(strip_tags($this->statePermit));
        $this->taxid=htmlspecialchars(strip_tags($this->taxid));
        $this->dba=htmlspecialchars(strip_tags($this->dba));
        $this->operation=htmlspecialchars(strip_tags($this->operation));
        $this->radius=htmlspecialchars(strip_tags($this->radius));
        $this->mailAddress=htmlspecialchars(strip_tags($this->mailAddress));
        $this->mailCity=htmlspecialchars(strip_tags($this->mailCity));
        $this->mailState=htmlspecialchars(strip_tags($this->mailState));
        $this->mailZip=htmlspecialchars(strip_tags($this->mailZip));

        $this->garageAddress=htmlspecialchars(strip_tags($this->garageAddress));
        $this->garageCity=htmlspecialchars(strip_tags($this->garageCity));
        $this->garageState=htmlspecialchars(strip_tags($this->garageState));
        $this->garageZip=htmlspecialchars(strip_tags($this->garageZip));

        $this->notes=htmlspecialchars(strip_tags($this->notes));
        $this->accountSource=htmlspecialchars(strip_tags($this->accountSource));
        $this->yearClient=htmlspecialchars(strip_tags($this->yearClient));
        $this->agent=htmlspecialchars(strip_tags($this->agent));
        
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
  
    function readOne() {

        $query = "SELECT 
                    accountid, 
                    accountStatus,
                    accountStatus.account_status AS accountStatus_name,
                    accountType,
                    accountTypes.account_type AS accountType_name,
                    usdot,
                    statePermit,
                    taxid,
                    authority,
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
                    WHERE accounts.accountid =  :accountid ";

        //prepare the query statement
            $stmt = $this->conn->prepare($query);

        // bind accountid to be read
            $stmt->bindParam(':accountid', $this->accountid);
            
        //execute query
            $stmt->execute();

            

        //get the retreived row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //set values to object properties
            $this->accountStatus = $row['accountStatus']; 
            $this->accountStatus_name = $row['accountStatus_name']; 
            $this->accountType = $row['accountType']; 
            $this->accountType_name = $row['accountType_name']; 
            $this->usdot = $row['usdot']; 
            $this->statePermit = $row['statePermit']; 
            $this->taxid = $row['taxid']; 
            $this->authority = $row['authority']; 
            $this->legalname = $row['legalname']; 
            $this->dba = $row['dba']; 
            $this->operation = $row['operation']; 
            $this->operation_name = $row['operation_name']; 

            $this->radius = $row['radius']; 
            $this->radius_name = $row['radius_name']; 

            $this->mailAddress = $row['mailAddress']; 
            $this->mailCity = $row['mailCity']; 
            $this->mailCity_name = $row['mailCity_name']; 
            $this->mailState = $row['mailState']; 
            $this->mailZip = $row['mailZip']; 

            $this->garageAddress = $row['garageAddress']; 
            $this->garageCity = $row['garageCity']; 
            $this->garageCity_name = $row['garageCity_name']; 
            $this->garageState = $row['garageState']; 
            $this->garageZip = $row['garageZip']; 

            $this->notes = $row['notes']; 
            $this->accountSource = $row['accountSource']; 
            $this->source_name = $row['source_name']; 
            $this->yearClient = $row['yearClient']; 
            $this->agent = $row['agent']; 
            $this->agent_name = $row['agent_name']; 
            $this->created = $row['created']; 

            $this->contacts = array();
            $this->policies = array();
            $this->drivers = array();
            $this->vehicles = array();
            $this->endorsements = array();
    }  
    
    function update() {
        //create update query
      
        //prepare the query statement
      
        //sanitize the update values
      
        //bind new values
      
        //execute the query statement
        
    }
    
    function search($keywords) {
        //create select query using like
        
        //prepare the query statement
      
        //sanitize values
      
        //bind values to properties
      
        //execute query
      
        //return rows
        
    }
}
?>
