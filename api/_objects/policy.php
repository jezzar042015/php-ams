<?php

class Policy{
    // database connection and table name
    private $conn;
    private $table_name = "policies";


    // objectProperties
    public $policyID;
    public $policyNumber;
    public $accountID;
    public $legalname;
    public $mgaID;
    public $mganame;
    public $carrierID;
    public $carriername;
    public $coverageType;
    public $coverageType_name;
    public $bindDate;
    public $effective;
    public $expiration;
    public $cancellation;

    public $baseperunit;
    public $duesperunit_nontaxed;
    public $pdrate;
    public $trailerrate;
    public $not_rate;
    public $ti_rate;
    public $bfrate;
    public $strate;
    public $commissionrate;

    public $premium;
    public $surcharge;
    public $policyfees;
    public $mgafees;
    public $surplusTax;
    public $brokerfees;
    public $otherfees;
    public $totalpremium;
    public $commission; 

    public $initial_premium;
    public $initial_surcharge;
    public $initial_surplusTax;
    public $initial_brokerfees;
    public $initial_endtfees;
    public $initial_otherfees;
    public $initial_totalpremium;
    public $initial_commission; 

    public $cummulative_premium;
    public $cummulative_surcharge;
    public $cummulative_surplusTax;
    public $cummulative_brokerfees;
    public $cummulative_endtfees;
    public $cummulative_otherfees;
    public $cummulative_totalpremium;
    public $cummulative_commission; 

    public $earned_commission; 
    public $unearned_commission;

    public $covered_vehicles;
    public $covered_drivers; 
    public $endorsements; 

    public $agentsplit;
    public $policystate;
    public $premiumfinancer;
    public $premiumfinancer_name;
    public $pf_accountNo;
    public $notes;
    public $onInceptionStage;

    public $agentName;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function read() {
        //select all query
        $query = 
            "SELECT 
                policyID,
                policyNumber,
                accountID,
                mgaID,
                carrierID,
                coverageType,
                bindDate,
                effective,
                expiration,
                cancellation,

                baseperunit,
                duesperunit_nontaxed,
                pdrate,
                trailerrate,
                not_rate,
                ti_rate,
                bfrate,
                strate,
                commissionrate,

                premium,
                surcharge,
                policyfees,
                mgafees,
                surplusTax,
                brokerfees,
                otherfees,
                totalpremium,
                commission,

                agentsplit,
                policystate,
                premiumfinancer,
                pf_accountNo,
                notes,
                onInceptionStage,
                created,
                modified
            FROM policies ORDER BY effective DESC";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
        
    }

    function readOne() {

    }

    function readByAccount() {
        
        //create query statement
            $query = 
            "SELECT 
                policyID,
                policyNumber,
                accountID,
                
                mgaID,
               
                carrierID,
                
                coverageType,
                
                bindDate,
                effective,
                expiration,
                cancellation,

                baseperunit,
                duesperunit_nontaxed,
                pdrate,
                trailerrate,
                not_rate,
                ti_rate,
                bfrate,
                strate,
                commissionrate,

                premium,
                surcharge,
                policyfees,
                mgafees,
                surplusTax,
                brokerfees,
                otherfees,
                totalpremium,
                commission,

                agentsplit,
                policystate,
                premiumfinancer,
                
                pf_accountNo,
                notes,
                onInceptionStage,
                created,
                modified

            FROM policies 
            
            WHERE accountid = :accountid
            ORDER BY effective DESC";

            //JOINED TABLES
            // policies, accounts, agents, mgas, carriers, banks

        //prepare the query statement
            $stmt = $this->conn->prepare($query);

        //bind variables to query
            $stmt->bindParam(':accountid', $this->accountid);

        //execute query
            $stmt->execute();

        //get the retrieved rows
            return $stmt;
        
    }

    function create() {
        // create append query
        $query = 
            "INSERT INTO policies 
            SET
                policyNumber=:policyNumber,
                accountID=:accountID,
                mgaID=:mgaID,
                carrierID=:carrierID,
                coverageType=:coverageType,
                bindDate=:bindDate,
                effective=:effective,
                expiration=:expiration,
                baseperunit=:baseperunit,
                duesperunit_nontaxed=:duesperunit_nontaxed,
                pdrate=:pdrate,
                trailerrate=:trailerrate,
                not_rate=:not_rate,
                ti_rate=:ti_rate,
                bfrate=:bfrate,
                strate=:strate,
                commissionrate=:commissionrate,
                premium=:premium,
                surcharge=:surcharge,
                policyfees=:policyfees,
                mgafees=:mgafees,
                surplusTax=:surplusTax,
                brokerfees=:brokerfees,
                otherfees=:otherfees,
                totalpremium=:totalpremium,
                commission=:commission,
                agentsplit=:agentsplit,
                policystate=:policystate,
                premiumfinancer=:premiumfinancer,
                pf_accountNo=:pf_accountNo,
                notes=:notes,
                onInceptionStage=:onInceptionStage
            ";

        // prepare query
        $stmt = $this->conn->prepare();

        // sanitize
        $this->policyNumber=htmlspecialchars(strip_tags($this->policyNumber));
        $this->accountID=htmlspecialchars(strip_tags($this->accountID));
        $this->mgaID=htmlspecialchars(strip_tags($this->mgaID));
        $this->carrierID=htmlspecialchars(strip_tags($this->carrierID));
        $this->coverageType=htmlspecialchars(strip_tags($this->coverageType));
        $this->bindDate=htmlspecialchars(strip_tags($this->bindDate));
        $this->effective=htmlspecialchars(strip_tags($this->effective));
        $this->expiration=htmlspecialchars(strip_tags($this->expiration));

        $this->baseperunit=htmlspecialchars(strip_tags($this->baseperunit));
        $this->duesperunit_nontaxed=htmlspecialchars(strip_tags($this->duesperunit_nontaxed));
        $this->pdrate=htmlspecialchars(strip_tags($this->pdrate));
        $this->trailerrate=htmlspecialchars(strip_tags($this->trailerrate));
        $this->not_rate=htmlspecialchars(strip_tags($this->not_rate));
        $this->ti_rate=htmlspecialchars(strip_tags($this->ti_rate));
        $this->bfrate=htmlspecialchars(strip_tags($this->bfrate));
        $this->strate=htmlspecialchars(strip_tags($this->strate));
        $this->commissionrate=htmlspecialchars(strip_tags($this->commissionrate));
        
        $this->premium=htmlspecialchars(strip_tags($this->premium));
        $this->surcharge=htmlspecialchars(strip_tags($this->surcharge));
        $this->policyfees=htmlspecialchars(strip_tags($this->policyfees));
        $this->mgafees=htmlspecialchars(strip_tags($this->mgafees));
        $this->surplusTax=htmlspecialchars(strip_tags($this->surplusTax));
        $this->brokerfees=htmlspecialchars(strip_tags($this->brokerfees));
        $this->otherfees=htmlspecialchars(strip_tags($this->otherfees));
        $this->totalpremium=htmlspecialchars(strip_tags($this->totalpremium));

        $this->commission=htmlspecialchars(strip_tags($this->commission));
        $this->agentsplit=htmlspecialchars(strip_tags($this->agentsplit));
        $this->policystate=htmlspecialchars(strip_tags($this->policystate));
        $this->premiumfinancer=htmlspecialchars(strip_tags($this->premiumfinancer));
        $this->pf_accountNo=htmlspecialchars(strip_tags($this->pf_accountNo));
        $this->notes=htmlspecialchars(strip_tags($this->notes));
        $this->onInceptionStage=htmlspecialchars(strip_tags($this->onInceptionStage));


        // bind values
        $stmt->bindParam(":policyNumber", $this->policyNumber);
        $stmt->bindParam(":accountID", $this->accountID);
        $stmt->bindParam(":mgaID", $this->mgaID);
        $stmt->bindParam(":carrierID", $this->carrierID);
        $stmt->bindParam(":coverageType", $this->coverageType);

        $stmt->bindParam(":bindDate", $this->bindDate);
        $stmt->bindParam(":effective", $this->effective);
        $stmt->bindParam(":expiration", $this->expiration);

        $stmt->bindParam(":baseperunit", $this->baseperunit);
        $stmt->bindParam(":duesperunit_nontaxed", $this->duesperunit_nontaxed);
        $stmt->bindParam(":pdrate", $this->pdrate);
        $stmt->bindParam(":trailerrate", $this->trailerrate);
        $stmt->bindParam(":not_rate", $this->not_rate);
        $stmt->bindParam(":ti_rate", $this->ti_rate);
        $stmt->bindParam(":bfrate", $this->bfrate);
        $stmt->bindParam(":strate", $this->strate);
        $stmt->bindParam(":commissionrate", $this->commissionrate);

        $stmt->bindParam(":premium", $this->premium);
        $stmt->bindParam(":surcharge", $this->surcharge);
        $stmt->bindParam(":policyfees", $this->policyfees);
        $stmt->bindParam(":mgafees", $this->mgafees);
        $stmt->bindParam(":surplusTax", $this->surplusTax);
        $stmt->bindParam(":brokerfees", $this->brokerfees);
        $stmt->bindParam(":otherfees", $this->otherfees);
        $stmt->bindParam(":totalpremium", $this->totalpremium);

        $stmt->bindParam(":commission", $this->commission);
        $stmt->bindParam(":agentsplit", $this->agentsplit);
        $stmt->bindParam(":policystate", $this->policystate);
        $stmt->bindParam(":premiumfinancer", $this->premiumfinancer);
        $stmt->bindParam(":pf_accountNo", $this->pf_accountNo);
        $stmt->bindParam(":notes", $this->notes);
        $stmt->bindParam(":onInceptionStage", $this->onInceptionStage);

        // execute query
        if ($stmt->execute()) {
            return array(
                "message"=> "Insert successful",
                "policyid"=> $this->conn->lastInsertId(),
                "policyNumber"=> $this->policyNumber,
                "coveragetype"=> $this->coverageType,
                "status"=> 200
            );
        }

        return array(
            "message"=> "Insert failed",
            "policynumber" => $this->policyNumber,
            "status" => 400
        );
    }

    function update() {

    }    
    
    function fetch_CoveredVehicles() {

    }

    function fetch_CoveredDrivers() {

    }

    
}

?>
