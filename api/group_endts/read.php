
<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../_config/database.php';
include_once '../_objects/grouped_endt.php';

$database = new Database();
$db = $database->getConnection();

$grp_endt = new GroupEndt($db);

if (isset($_GET['accountid'])) {
    $grp_endt->accountid = $_GET['accountid'];
    $stmt = $grp_endt->read();
}

$num = $stmt->rowCount();

if ($num > 0) {
    $grp_endt_array = array(
        "count"=>$num,
        "grp_endts"=> array()
    );

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $grp_endt_item = array(
            "effective"=>$effective,
            "action_name"=>$action_name,
            "endt_description"=>$endt_description,
            "vehicle_year"=>$vehicle_year,
            "makename"=>$makename,
            "vin"=>$vin,
            "pdvalue"=>$pdvalue,
            "surcharge"=>$surcharge,
            "al_premium"=>$al_premium,
            "mtc_premium"=>$mtc_premium,
            "pd_premium"=>$pd_premium,
            "brokerfees"=>$brokerfees,
            "endtfees"=>$endtfees,
            "otherfees"=>$otherfees,
            "totalpremium"=>$totalpremium,
            "al_status"=>$al_status,
            "mtc_status"=>$mtc_status,
            "pd_status"=>$pd_status,
            "accountid"=>$grp_endt->accountid           
        );

        array_push($grp_endt_array['grp_endts'],$grp_endt_item);
    }

    http_response_code(200);

    echo json_encode(
        $grp_endt_array
    );

} else {
    echo json_encode(
        array(
            "count"=> 0,
            "message"=> "No endorsements found"
        )
    );
}



?>