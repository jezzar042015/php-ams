<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../_config/database.php';
    include_once '../_objects/carrier.php';

    $database = new Database();
    $db = $database->getConnection();
    
    $carrier = new Carrier($db);

    $stmt = $carrier->read();
    $num = $stmt->rowCount();

    echo $num;

    if ($num > 0) {
        
        $carriers_arr=array(
            "count"=>$num,
            "carriers"=>array(),
            "error" => false
        );

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            extract($row);

            $carrier_item=array(
                "carrierid"=>$carrierid,
                "carriername"=>$carriername,
                "agencycode"=>$agencycode,
                "ambest_rating"=>$ambest_rating,
                "phones"=>$phones,
                "emails"=>$emails,
                "carr_address"=>$carr_address,
                "carr_city"=>$carr_city,
                "carr_cityname"=>$carr_cityname,
                "carr_state"=>$carr_state,
                "carr_zip"=>$carr_zip,
                "website"=>$website,
                "notes"=>$notes,
                "created"=>$created,
                "modified"=>$modified
            );

            array_push($carriers_arr["carriers"],$carrier_item);
        }

        http_response_code(200);
        
        echo json_encode($carriers_arr);

    }

    else {

        http_response_code(404);
        
        echo json_encode(array(
            "message" => "No carriers found",
            "error" => true
        ));


    }

?>