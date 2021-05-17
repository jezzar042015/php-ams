<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../_config/database.php';
include_once '../_objects/vehicle.php';

$database = new Database();
$db = $database->getConnection();

$vehicle = new Vehicle($db);

if (isset($_GET['accountid'])) {
    $vehicle->accountid = $_GET['accountid'];
    $stmt = $vehicle->read_byAccount();
} else {
    $stmt = $vehicle->read();
}

$num = $stmt->rowCount();

if ($num > 0) {

    $vehicles_arr = array(
        "count"=>$num,
        "vehicles"=> array()
    );

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $vehicle_item = array(
            "vehicleid"=>$vehicleid, 
            "vin"=>$vin, 
            "vehicle_year"=>$vehicle_year, 
            "makeid"=>$makeid, 
            "makename"=>$makename, 
            "typeid"=>$typeid, 
            "typename"=>$typename, 
            "model"=>$model, 
            "unit_number"=>$unit_number, 
            "pdvalue"=>$pdvalue, 
            "driverid"=>$driverid, 
            "drivername"=>$drivername, 
            "lienholder"=>$lienholder, 
            "accountid"=>$accountid, 
            "notes"=>$notes, 
            "created"=>$created, 
            "modified"=>$modified           
        );

        array_push($vehicles_arr['vehicles'],$vehicle_item);
    }

    http_response_code(200);

    echo json_encode($vehicles_arr);

} else {

    echo json_encode(
        array(
            "count"=> 0,
            "message"=> "No vehicles found"
        )
    );
}


?>