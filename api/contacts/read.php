<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../_config/database.php';
include_once '../_objects/contact.php';

$database = new Database();
$db = $database->getConnection();

$contact = new Contact($db);

if (isset($_GET['accountid'])) {
    $contact->accountid = $_GET['accountid'];
    $stmt = $contact->read_byAccount();
} else {
    $stmt = $contact->read();
}

$num = $stmt->rowCount();

if ($num > 0) {

    $contacts_arr = array(
        "count"=>$num,
        "contacts"=>array()
    );

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        extract($row);

        $contact_item=array(
          "contactid"=>$contactid, 
          "firstname"=>$firstname, 
          "middlename"=>$middlename, 
          "lastname"=>$lastname, 
          "title"=>$title, 
          "business_phone"=>$business_phone, 
          "direct_phone"=>$direct_phone, 
          "mobile_phone"=>$mobile_phone, 
          "email1"=>$email1, 
          "email2"=>$email2, 
          "accountid"=>$accountid, 
          "notes"=>$notes, 
          "created"=>$created, 
          "modified"=>$modified
        );

        array_push($contacts_arr['contacts'],$contact_item);
    }

    http_response_code(200);

    echo json_encode($contacts_arr);

} else {

    http_response_code(404);

    echo json_encode(
        array(
            "count"=> 0,
            "message"=> "No contacts found"
        )
    );
}

?>