<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/enregistrement.php';
 
// instantiate database and enregistrement object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$enregistrement = new Enregistrement($db);

 // query enregistrement
$stmt = $enregistrement->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //enregistrements array
    $enregistrements_arr=array();
    $enregistrements_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $enregistrement_item=array(
			"egt_id" => $egt_id,
			"egt_dateheure" => $egt_dateheure,
			"egt_pm25" => $egt_pm25,
			"egt_pm10" => $egt_pm10,
			"egt_o3" => $egt_o3,
			"egt_no2" => $egt_no2,
			"egt_co" => $egt_co,
			"egt_p" => $egt_p,
			"egt_temperature" => $egt_temperature,
			"egt_lat" => $egt_lat,
			"egt_lng" => $egt_lng,
			"cpt_id" => $cpt_id,
			"cpt_nom" => $cpt_nom,
			"usr_id" => $usr_id,
			"usr_nom" => $usr_nom,
			"usr_prenom" => $usr_prenom
        );
 
        array_push($enregistrements_arr["records"], $enregistrement_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show enregistrements data in json format
    echo json_encode($enregistrements_arr);
} else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no enregistrement found
    echo json_encode(
        array("message" => "No enregistrements found.")
    );
}
 
 ?>