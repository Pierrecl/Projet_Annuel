<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/capteur.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare capteur object
$capteur = new Capteur($db);
 
// set ID property of record to read
$capteur->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of capteur to be edited
$capteur->readOne();
 
if($capteur->usr_nom!=null){
    // create array
    $capteur_arr = array(
		"cpt_id" =>  $capteur->id,
        "cpt_nom" => $capteur->cpt_nom,
        "usr_id" => $capteur->usr_id,
        "usr_nom" => $capteur->usr_nom,
        "usr_prenom" => $capteur->usr_prenom
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($capteur_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user capteur does not exist
    echo json_encode(array("message" => "Capteur does not exist."));
}
?>