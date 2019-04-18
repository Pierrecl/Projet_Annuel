<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/enregistrement.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare enregistrement object
$enregistrement = new Enregistrement($db);
 
// get id of enregistrement to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of enregistrement to be edited
$enregistrement->egt_id = $data->egt_id;
 
// set enregistrement property values
$enregistrement->egt_dateheure = $data->egt_dateheure;
$enregistrement->egt_pm25 = $data->egt_pm25;
$enregistrement->egt_pm10 = $data->egt_pm10;
$enregistrement->egt_o3 = $data->egt_o3;
$enregistrement->egt_no2 = $data->egt_no2;
$enregistrement->egt_co = $data->egt_co;
$enregistrement->egt_p = $data->egt_p;
$enregistrement->egt_temperature = $data->egt_temperature;
$enregistrement->egt_lat = $data->egt_lat;
$enregistrement->egt_lng = $data->egt_lng;
$enregistrement->cpt_id = $data->cpt_id;
 
// update the enregistrement
if($enregistrement->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Enregistrement was updated."));
}
 
// if unable to update the enregistrement, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update enregistrement."));
}
?>