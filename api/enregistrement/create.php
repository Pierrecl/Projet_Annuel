<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate enregistrement object
include_once '../objects/enregistrement.php';
 
$database = new Database();
$db = $database->getConnection();
 
$enregistrement = new Enregistrement($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
	!empty($data->egt_pm25) &&
	!empty($data->egt_pm10) &&
	!empty($data->egt_o3) &&
	!empty($data->egt_no2) &&
	!empty($data->egt_co) &&
	!empty($data->egt_p) &&
	!empty($data->egt_temperature) &&
	!empty($data->egt_lat) &&
	!empty($data->egt_lng) &&
	!empty($data->cpt_id)
){
 
    // set enregistrement property values
	$enregistrement->egt_dateheure = date('Y-m-d H:i:s');
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

    // create the enregistrement
    if($enregistrement->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Enregistrement was created."));
    }
 
    // if unable to create the enregistrement, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create enregistrement."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create enregistrement. Data is incomplete."));
}
?>