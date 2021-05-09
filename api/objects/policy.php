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
    
    function create() {

    }

    function update() {

    }    
    
    function fetch_CoveredVehicles() {

    }

    function fetch_CoveredDrivers() {

    }

    
}

?>
