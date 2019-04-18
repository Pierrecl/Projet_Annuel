<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/capteur.php';
 
// instantiate database and capteur object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$capteur = new Capteur($db);

 // query capteur
$stmt = $capteur->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // capteurs array
    $capteurs_arr=array();
    $capteurs_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $capteur_item=array(
			"cpt_id" => $cpt_id,
			"cpt_nom" => $cpt_nom,
			"usr_id" => $usr_id,
			"usr_nom" => $usr_nom,
			"usr_prenom" => $usr_prenom
        );
 
        array_push($capteurs_arr["records"], $capteur_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show capteurs data in json format
    echo json_encode($capteurs_arr);
} else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no capteur found
    echo json_encode(
        array("message" => "No capteurs found.")
    );
}
 
 ?>