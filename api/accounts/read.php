<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../_config/database.php';
include_once '../_objects/account.php';

// instantiate database object
$database = new Database();
$db = $database->getConnection();
  
// initialize account object
$account = new Account($db);
  
// query accounts
$stmt = $account->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // accounts array
    $accounts_arr=array();
    $accounts_arr["accounts"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $account_item=array(
            "accountid" => $accountid,
            "accountStatus" => $accountStatus,
            "accountStatus_name" => $accountStatus_name,
            "accountType" => $accountType,
            "accountType_name" => $accountType_name,
            "usdot" => $usdot,
            "statePermit" => $statePermit,
            "taxid" => $taxid,
            "authority" => $authority,
            "legalname" => $legalname,
            "dba" => $dba,
            "operation" => $operation,
            "operation_name" => $operation_name,
            "radius" => $radius,
            "radius_name" => $radius_name,
            "mailAddress" => $mailAddress,
            "mailCity" => $mailCity,
            "mailCity_name" => $mailCity_name,
            "mailState" => $mailState, 
            "mailZip" => $mailZip,
            "garageAddress" => $garageAddress,
            "garageCity" => $garageCity,
            "garageCity_name" => $garageCity_name,
            "garageState" => $garageState,
            "garageZip" => $garageZip,
            "notes" => $notes,
            "accountSource" => $accountSource,
            "source_name" => $source_name,
            "yearClient" => $yearClient,
            "agent" => $agent,
            "agent_name" => $agent_name,
            "created" => $created
        );
  
        array_push($accounts_arr["accounts"], $account_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show accounts data in json format
    echo json_encode($accounts_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no accounts found
    echo json_encode(
        array("message" => "No accounts found.")
    );
}
