<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and the policy object
include_once '../config/database.php';
include_once '../config/policy.php';

// instantiate database  
$database = new Database();
$db = $database->getConnection();

// instantiate policy object
$policy = new Policy();

//query accounts
$stmt = $policy->read();

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
            "accountid" => $accountid,
            "legalname"=> $legalname,
            "mgaID"=> $mgaID,
            "mganame"=> $mganame,
            "carrierID"=> $carrierID,
            "carriername"=> $carriername,
            "coverageType"=> $coverageType,
            "coverageType_name"=> $coverageType_name,
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

            "initial_premium"=> $initial_premium:
            "initial_surcharge"=> $initial_surcharge,
            "initial_surplusTax"=> $initial_surplusTax,
            "initial_brokerfees"=> $initial_brokerfees,
            "initial_endtfees"=> $initial_endtfees,
            "initial_otherfees"=> $initial_otherfees,
            "initial_totalpremium"=> $initial_totalpremium,
            "initial_commission"=> $initial_commission, 
        
            "cummulative_premium"=> $cummulative_premium:
            "cummulative_surcharge"=> $cummulative_surcharge,
            "cummulative_surplusTax"=> $cummulative_surplusTax,
            "cummulative_brokerfees"=> $cummulative_brokerfees,
            "cummulative_endtfees"=> $cummulative_endtfees,
            "cummulative_otherfees"=> $cummulative_otherfees,
            "cummulative_totalpremium"=> $cummulative_totalpremium,
            "cummulative_commission"=> $cummulative_commission, 
        
            "earned_commission"=> $earned_commission, 
            "unearned_commission"=> $unearned_commission,
        
            "covered_vehicles"=> $covered_vehicles,
            "covered_drivers"=> $covered_drivers, 
            "endorsements"=> $endorsements, 
        
            "agentsplit"=> $agentsplit,
            "policystate"=> $policystate,
            "premiumfinancer"=> $premiumfinancer,
            "pf_accountNo"=> $pf_accountNo,
            "notes"=> $notes,
            "onInceptionStage"=> $onInceptionStage,
        
            "agentName"=> $agentName,

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
