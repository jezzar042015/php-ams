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
    $policies_array = array();
    $policies_array["policies"]=array();

    

} else {

}

?>
