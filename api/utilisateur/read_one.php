<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/utilisateur.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare utilisateur object
$utilisateur = new Utilisateur($db);
 
// set ID property of record to read
$utilisateur->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of utilisateur to be edited
$utilisateur->readOne();
 
if($utilisateur->usr_nom!=null){
    // create array
    $utilisateur_arr = array(
        "usr_id" =>  $utilisateur->id,
        "usr_nom" => $utilisateur->usr_nom,
        "usr_prenom" => $utilisateur->usr_prenom,
        "usr_datecreation" => $utilisateur->usr_datecreation,
        "usr_type" => $utilisateur->usr_type
 
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($utilisateur_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user utilisateur does not exist
    echo json_encode(array("message" => "Utilisateur does not exist."));
}
?>