<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate account object
include_once '../_objects/account.php';
  
$database = new Database();
$db = $database->getConnection();
  
$account = new Account($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->legalname)
){
  
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
    $account->created = date('Y-m-d H:i:s');
  
    // register new account
    $create_result = $account->create();

    if($create_result > 0){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(
            array(
                "message" => "account was added",
                "accountid" => $create_result
            )
        );
    }
  
    // if unable to create the product, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to add account."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to add account. No legal name identified."));
}
?>