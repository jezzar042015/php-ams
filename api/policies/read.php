<?php

// required headers either with GET values or none
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and the policy object
include_once '../_config/database.php';
include_once '../_objects/policy.php';

// instantiate database  
$database = new Database();
$db = $database->getConnection();

// instantiate policy object
$policy = new Policy($db);

// //set the accountid of account object from GET
// $policy->accountid = isset($_GET['accountid']) ? $_GET['accountid']: 

if (isset($_GET['accountid'])) {
    $policy->accountid = $_GET['accountid'];
    $stmt = $policy->readByAccount();
} else {
    $stmt = $policy->read();
}

//count results
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // prepare policy arrays
    $policies_arr = array();
    $policies_arr["policies"]=array();

    //retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $policy_item=array(
            "policyID" => $policyID,
            "policyNumber"=> $policyNumber,
            "accountID" => $accountID,
            "legalname"=> $legalname,
            "mgaID"=> $mgaID,
            "mganame"=> $mganame,
            "carrierID"=> $carrierID,
            "carriername"=> $carriername,
            "coverageType"=> $coverageType,
            "coveragetype_name"=> $coveragetypename,
            "bindDate"=> $bindDate,
            "effective"=> $effective,
            "expiration"=> $expiration,
            "cancellation"=> $cancellation,

            "baseperunit" => $baseperunit,
            "duesperunit_nontaxed" => $duesperunit_nontaxed,
            "pdrate" => $pdrate,
            "trailerrate" => $trailerrate,
            "not_rate" => $not_rate,
            "ti_rate" => $ti_rate,
            "bfrate" => $bfrate,
            "strate"=> $strate,
            "commissionrate" => $commissionrate,

            "premium"=> $premium,
            "surcharge"=> $surcharge,
            "policyfees"=> $policyfees,
            "mgafees"=> $mgafees,
            "surplusTax"=> $surplusTax,
            "brokerfees"=> $brokerfees,
            "otherfees"=> $otherfees,
            "totalpremium"=> $totalpremium,
            "commission"=> $commission, 

            "initial_premium"=> $initial_premium,
            // "initial_surcharge"=> $initial_surcharge,
            // "initial_surplusTax"=> $initial_surplusTax,
            // "initial_brokerfees"=> $initial_brokerfees,
            // "initial_endtfees"=> $initial_endtfees,
            // "initial_otherfees"=> $initial_otherfees,
            // "initial_totalpremium"=> $initial_totalpremium,
            // "initial_commission"=> $initial_commission, 
        
            "cummulative_premium"=> $cummulative_premium,
            // "cummulative_surcharge"=> $cummulative_surcharge,
            // "cummulative_surplusTax"=> $cummulative_surplusTax,
            // "cummulative_brokerfees"=> $cummulative_brokerfees,
            // "cummulative_endtfees"=> $cummulative_endtfees,
            // "cummulative_otherfees"=> $cummulative_otherfees,
            // "cummulative_totalpremium"=> $cummulative_totalpremium,
            // "cummulative_commission"=> $cummulative_commission, 
        
            // "earned_commission"=> $earned_commission, 
            // "unearned_commission"=> $unearned_commission,
        
            "covered_vehicles"=> array(),
            "covered_drivers"=> array(), 
            "endorsements"=> array(), 
        
            "agentsplit"=> $agentsplit,
            "policystate"=> $policystate,
            "premiumfinancer"=> $premiumfinancer,
            "pf_accountNo"=> $pf_accountNo,
            "notes"=> $notes,
            "onInceptionStage"=> $onInceptionStage

            // "agentName"=> $agentName

        );

        array_push($policies_arr["policies"],$policy_item);
    }

        //set response code - 200 OK
        http_response_code(200);

        // convert results json format
        echo json_encode($policies_arr);

} else {
        // set not found response code - 404
        http_response_code(404);
        
        // tell the user no policies found
        echo json_encode(
            array(
                "message" => "No policies found"
            )
        );
}

?>
