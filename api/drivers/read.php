<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../_config/database.php';
include_once '../_objects/driver.php';

$database = new Database();
$db = $database->getConnection();

$driver = new Driver($db);

if (isset($_GET['accountid'])) {
    $driver->accountid = $_GET['accountid'];
    $stmt = $driver->read_byAccount();
} else {
    $stmt = $driver->read();
}

$num = $stmt->rowCount();

if ($num > 0) {

    $drivers_arr = array(
        "count"=>$num,
        "drivers"=> array()
    );

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $driver_item = array(
            "driverid" =>$driverid, 
            "firstname" =>$firstname, 
            "middlename" =>$middlename, 
            "lastname" =>$lastname, 
            "hiredate" =>$hiredate, 
            "terminationdate" =>$terminationdate, 
            "dob" =>$dob, 
            "cdl_state" =>$cdl_state, 
            "cdl_number" =>$cdl_number, 
            "year_licensed" =>$year_licensed, 
            "phone" =>$phone, 
            "email" =>$email, 
            "isOwnerOperator" =>$isOwnerOperator, 
            "accountid" =>$accountid, 
            "notes" =>$notes, 
            "created" =>$created, 
            "modified" =>$modified 
        );

        array_push($drivers_arr['drivers'],$driver_item);
    }

    http_response_code(200);

    echo json_encode($drivers_arr);

} else {

    echo json_encode(
        array(
            "count"=> 0,
            "message"=> "No drivers found"
        )
    );
}

?>