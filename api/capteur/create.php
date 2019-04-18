<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate capteur object
include_once '../objects/capteur.php';
 
$database = new Database();
$db = $database->getConnection();
 
$capteur = new Capteur($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->cpt_nom) &&
    !empty($data->usr_id)
){
 
    // set capteur property values
    $capteur->cpt_nom = $data->cpt_nom;
    $capteur->usr_id = $data->usr_id;
 
    // create the capteur
    if($capteur->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Capteur was created."));
    }
 
    // if unable to create the capteur, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create capteur."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create capteur. Data is incomplete."));
}
?>