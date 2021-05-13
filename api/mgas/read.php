<?php
//required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and mga object
include_once '../_config/database.php';
include_once '../_objects/mga.php';

//initiate database objects
$database = new Database();
$db = $database->getConnection();

// initiate mga object
$mga = new MGA($db);

// fetch mga records
$stmt = $mga->read();
$num = $stmt->rowCount();

if($num > 0) {
    //create mgas array
    $mgas_arr=array(
        "count"=> $num,
        "mgas"=> array()
    );


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $mga_item=array(
            "mgaid"=>$mgaid,
            "mganame"=>$mganame,
            "writingstate"=>$writingstate,
            "carriers"=>$carriers,
            "phones"=>$phones,
            "emails"=>$emails,
            "mga_address"=>$mga_address,
            "mga_city"=>$mga_city,
            "mga_cityname"=>$mga_cityname,
            "mga_state"=>$mga_state,
            "mga_zip"=>$mga_zip,
            "website"=>$website,
            "endtFees"=>$endtFees,
            "notes"=>$notes,
            "created"=>$created,
            "modified"=>$modified
        );

        array_push($mgas_arr["mgas"],$mga_item);
    }

    http_response_code(200);

    echo json_encode($mgas_arr);
}

?>