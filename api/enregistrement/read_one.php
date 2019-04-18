<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/enregistrement.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare enregistrement object
$enregistrement = new Enregistrement($db);
 
// set ID property of record to read
$enregistrement->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of enregistrement to be edited
$enregistrement->readOne();
 
if($enregistrement->usr_nom!=null){
    // create array
    $enregistrement_arr = array(
		"egt_id" =>  $enregistrement->id,
		"egt_dateheure" =>  $enregistrement->egt_dateheure,
		"egt_pm25" => $enregistrement->egt_pm25,
		"egt_pm10" => $enregistrement->egt_pm10,
		"egt_o3" => $enregistrement->egt_o3,
		"egt_no2" => $enregistrement->egt_no2,
		"egt_co" => $enregistrement->egt_co,
		"egt_p" => $enregistrement->egt_p,
		"egt_temperature" => $enregistrement->egt_temperature,
		"egt_lat" => $enregistrement->egt_lat,
		"egt_lng" => $enregistrement->egt_lng,
		"cpt_id" => $enregistrement->cpt_id,
		"cpt_nom" => $enregistrement->cpt_nom,
		"usr_id" => $enregistrement->usr_id,
		"usr_nom" => $enregistrement->usr_nom,
		"usr_prenom" => $enregistrement->usr_prenom
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($enregistrement_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user enregistrement does not exist
    echo json_encode(array("message" => "Enregistrement does not exist."));
}
?>