<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../_config/database.php';
include_once '../_objects/account.php';

$database = new Database();
$db = $database->getConnection();

//prepare account object
$account = New Account($db);

//set the accountid of account object from GET
$account->accountid = isset($_GET['accountid']) ? $_GET['accountid']: die();

// read the account using the accountID
$account->readOne();

if ($account->legalname != null) {
    //create array
    $account_arr = array(
        "accountid" => $account->accountid,
        "accountStatus" => $account->accountStatus,
        "accountStatus_name" => $account->accountStatus_name,
        "accountType"=> $account->accountType,
        "accountType_name"=> $account->accountType_name,
        "usdot"=> $account->usdot,
        "statePermit"=> $account->statePermit,
        "taxid"=> $account->taxid,
        "legalname" => $account->legalname,
        "dba"=> $account->dba,
        "operation"=> $account->operation,
        "operation_name"=> $account->operation_name,
        "radius"=> $account->radius,
        "radius_name"=> $account->radius_name,
        "mailAddress"=> $account->mailAddress,
        "mailCity"=> $account->mailCity,
        "mailCity_name"=> $account->mailCity_name,
        "mailState"=> $account->mailState,
        "mailZip"=> $account->mailZip,
        "garageAddress"=> $account->garageAddress,
        "garageCity"=> $account->garageCity,
        "garageCity_name"=> $account->garageCity_name,
        "garageState"=> $account->garageState,
        "garageZip"=> $account->garageZip,


        "notes"=> $account->notes,
        "accountSource"=> $account->accountSource,
        "source_name"=> $account->source_name,
        "yearClient"=> $account->yearClient,
        "agent"=> $account->agent,
        "agent_name"=> $account->agent_name,
        "created"=> $account->created,

        "contacts"=> $account->contacts,
        "policies"=> $account->policies,
        "drivers"=> $account->drivers,
        "vehicles"=> $account->vehicles,
        "endorsements"=> $account->endorsements
    );

    // set response code 200 - OK
    http_response_code(200);

    // convert to JSON format
    echo json_encode($account_arr);

} else {
    // set response code 400 - Not Found
    http_response_code(404);

    // convert to JSON format
    echo json_encode(array(
        "message" => "Account does not exist."
    ));
}
?>
