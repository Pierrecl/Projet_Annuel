<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/utilisateur.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare utilisateur object
$utilisateur = new Utilisateur($db);
 
// get id of utilisateur to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of utilisateur to be edited
$utilisateur->usr_id = $data->usr_id;
 
// set utilisateur property values
$utilisateur->usr_nom = $data->usr_nom;
$utilisateur->usr_prenom = $data->usr_prenom;
$utilisateur->usr_datecreation = $data->usr_datecreation;
$utilisateur->usr_type = $data->usr_type;
 
// update the utilisateur
if($utilisateur->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
    echo json_encode(array("message" => "Utilisateur was updated."));
}
 
// if unable to update the utilisateur, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
    echo json_encode(array("message" => "Unable to update utilisateur."));
}
?>