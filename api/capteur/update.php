<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/capteur.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare capteur object
$capteur = new Capteur($db);
 
// get id of capteur to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of capteur to be edited
$capteur->cpt_id = $data->cpt_id;
 
// set capteur property values
$capteur->cpt_nom = $data->cpt_nom;
$capteur->usr_id = $data->usr_id;
 
// update the capteur
if($capteur->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Capteur was updated."));
}
 
// if unable to update the capteur, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update capteur."));
}
?>