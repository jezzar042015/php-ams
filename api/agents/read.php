<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../_config/database.php';
include_once '../_objects/agent.php';

$database = new Database();
$db = $database->getConnection();

$agent = new Agent($db);

// agentid
if (isset($_GET['agentid'])) {
    $agent->agentid = $_GET['agentid'];
    $stmt = $agent->readOne();
} else {
    $stmt = $agent->read();
}

$num = $stmt->rowCount();

if ($num > 0) {

    $agents_arr = array(
        "count"=>$num,
        "agents"=>array()
    );
    

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $agent_item = array(
            "agentID"=>$agentID, 
            "isInactive"=>$isInactive, 
            "lastName"=>$lastName, 
            "firstName"=>$firstName, 
            "email"=>$email, 
            "commSplit_new"=>$commSplit_new, 
            "commSplit_renew"=>$commSplit_renew, 
            "brokerFeeSplit"=>$brokerFeeSplit, 
            "created"=>$created, 
            "modified"=>$modified            
        );

        array_push($agents_arr['agents'],$agent_item);

    }

    http_response_code(200);

    echo json_encode($agents_arr);

} else {

    http_response_code(404);

    echo json_encode(
        array(
            "count"=> 0,
            "message" => "No agent found"
        ));

};

?>