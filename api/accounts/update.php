<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/account.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare account object
$account = new Account($db);

// get account data to be set for update
$data = json_decode(file_get_contents("php://input"));

// set accountid property of account to be updated
$account->accountid = $data->accountid;

// set account properties for update
    // set account property values
    $account->legalname = $data->legalname;
    $account->accountStatus = $data->accountStatus;
    $account->accountType = $data->accountType;
    $account->usdot = $data->usdot;
    $account->statePermit = $data->statePermit;
    $account->taxid = $data->taxid;
    $account->dba = $data->dba;
    $account->operation = $data->operation;
    $account->radius = $data->radius;
    $account->mailAddress = $data->mailAddress;
    $account->mailCity = $data->mailCity;
    $account->mailState = $data->mailState;
    $account->mailZip = $data->mailZip;
    $account->garageAddress = $data->garageAddress;
    $account->garageCity = $data->garageCity;
    $account->garageState = $data->garageState;
    $account->garageZip = $data->garageZip;
    $account->notes = $data->notes;
    $account->accountSource = $data->accountSource;
    $account->yearClient = $data->yearClient;
    $account->agent = $data->agent;
    $account->modified = date('Y-m-d H:i:s');

    //update the account
    if($account->update()){
  
        // set response code - 200 ok
        http_response_code(200);
      
        // tell the user
        echo json_encode(array("message" => "Account was updated."));
    }
      
    // if unable to update the account, tell the user
    else{
      
        // set response code - 503 service unavailable
        http_response_code(503);
      
        // tell the user
        echo json_encode(array("message" => "Unable to update account."));
    }
?>
  
