<?php
class Enregistrement{
 
    // database connection and table name
    private $conn;
    private $table_name = "ENREGISTREMENT";
 
    // object properties
    public $egt_id;
    public $egt_dateheure;
    public $egt_pm25;
    public $egt_pm10;
    public $egt_o3;
    public $egt_no2;
    public $egt_co;
    public $egt_p;
    public $egt_temperature;
	public $egt_lat;
	public $egt_lng;
    public $cpt_id;
    public $cpt_nom;
    public $usr_id;
    public $usr_nom;
    public $usr_prenom;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	// read products
	function read(){
	 
		// select all query
		$query = "SELECT
				e.egt_id,
				e.egt_dateheure,
				e.egt_pm25,
				e.egt_pm10,
				e.egt_o3,
				e.egt_no2,
				e.egt_co,
				e.egt_p,
				e.egt_temperature,
				e.egt_lat,
				e.egt_lng,
				e.cpt_id,
				c.cpt_nom,
				u.usr_id,
				u.usr_nom,
				u.usr_prenom								
				FROM " . $this->table_name . " e
					LEFT JOIN CAPTEUR c on c.CPT_ID = e.CPT_ID
					LEFT JOIN UTILISATEUR u on u.USR_ID = c.USR_ID";

		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	// create product
	function create(){
	 // query to insert record
		$query = "INSERT INTO 
					" . $this->table_name . " 
				SET
					egt_dateheure=:egt_dateheure,
					egt_pm25=:egt_pm25,
					egt_pm10=:egt_pm10,
					egt_o3=:egt_o3,
					egt_no2=:egt_no2,
					egt_co=:egt_co,
					egt_p=:egt_p,
					egt_temperature=:egt_temperature,
					egt_lat=:egt_lat,
					egt_lng=:egt_lng,
					cpt_id=:cpt_id";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->egt_dateheure=htmlspecialchars(strip_tags($this->egt_dateheure));
		$this->egt_pm25=htmlspecialchars(strip_tags($this->egt_pm25));
		$this->egt_pm10=htmlspecialchars(strip_tags($this->egt_pm10));
		$this->egt_o3=htmlspecialchars(strip_tags($this->egt_o3));
		$this->egt_no2=htmlspecialchars(strip_tags($this->egt_no2));
		$this->egt_co=htmlspecialchars(strip_tags($this->egt_co));
		$this->egt_p=htmlspecialchars(strip_tags($this->egt_p));
		$this->egt_temperature=htmlspecialchars(strip_tags($this->egt_temperature));
		$this->egt_lat=htmlspecialchars(strip_tags($this->egt_lat));
		$this->egt_lng=htmlspecialchars(strip_tags($this->egt_lng));
		$this->cpt_id=htmlspecialchars(strip_tags($this->cpt_id));
	 
		// bind values
		$stmt->bindParam(":egt_dateheure", $this->egt_dateheure);
		$stmt->bindParam(":egt_pm25", $this->egt_pm25);
		$stmt->bindParam(":egt_pm10", $this->egt_pm10);
		$stmt->bindParam(":egt_o3", $this->egt_o3);
		$stmt->bindParam(":egt_no2", $this->egt_no2);
		$stmt->bindParam(":egt_co", $this->egt_co);
		$stmt->bindParam(":egt_p", $this->egt_p);
		$stmt->bindParam(":egt_temperature", $this->egt_temperature);
		$stmt->bindParam(":egt_lat", $this->egt_lat);
		$stmt->bindParam(":egt_lng", $this->egt_lng);
		$stmt->bindParam(":cpt_id", $this->cpt_id);

		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
	// used when filling up the update product form
	function readOne(){
	 
		// query to read single record
		$query = "SELECT
				e.egt_id,
				e.egt_dateheure,
				e.egt_pm25,
				e.egt_pm10,
				e.egt_o3,
				e.egt_no2,
				e.egt_co,
				e.egt_p,
				e.egt_temperature,
				e.egt_lat,
				e.egt_lng,
				e.cpt_id,
				c.cpt_nom,
				u.usr_id,
				u.usr_nom,
				u.usr_prenom								
				FROM " . $this->table_name . " e
					LEFT JOIN CAPTEUR c on c.CPT_ID = e.CPT_ID
					LEFT JOIN UTILISATEUR u on u.USR_ID = c.USR_ID
				WHERE
					e.egt_id = ?";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of utilisateur to be updated
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		// set values to object properties
		$this->egt_dateheure = $row['egt_dateheure'];
		$this->egt_pm25 = $row['egt_pm25'];
		$this->egt_pm10 = $row['egt_pm10'];
		$this->egt_o3 = $row['egt_o3'];
		$this->egt_no2 = $row['egt_no2'];
		$this->egt_co = $row['egt_co'];
		$this->egt_p = $row['egt_p'];
		$this->egt_temperature = $row['egt_temperature'];
		$this->egt_lat = $row['egt_lat'];
		$this->egt_lng = $row['egt_lng'];
		$this->cpt_id = $row['cpt_id'];
		$this->cpt_nom = $row['cpt_nom'];
		$this->usr_id = $row['usr_id'];
		$this->usr_nom = $row['usr_nom'];
		$this->usr_prenom = $row['usr_prenom'];

	}
	
	
	// update the enregistrement
	function update(){
	 
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					egt_dateheure=:egt_dateheure,
					egt_pm25=:egt_pm25,
					egt_pm10=:egt_pm10,
					egt_o3=:egt_o3,
					egt_no2=:egt_no2,
					egt_co=:egt_co,
					egt_p=:egt_p,
					egt_temperature=:egt_temperature,
					egt_lat=:egt_lat,
					egt_lng=:egt_lng,
					cpt_id=:cpt_id
				WHERE
					egt_id=:egt_id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->egt_dateheure=htmlspecialchars(strip_tags($this->egt_dateheure));
		$this->egt_pm25=htmlspecialchars(strip_tags($this->egt_pm25));
		$this->egt_pm10=htmlspecialchars(strip_tags($this->egt_pm10));
		$this->egt_o3=htmlspecialchars(strip_tags($this->egt_o3));
		$this->egt_no2=htmlspecialchars(strip_tags($this->egt_no2));
		$this->egt_co=htmlspecialchars(strip_tags($this->egt_co));
		$this->egt_p=htmlspecialchars(strip_tags($this->egt_p));
		$this->egt_temperature=htmlspecialchars(strip_tags($this->egt_temperature));
		$this->egt_lat=htmlspecialchars(strip_tags($this->egt_lat));
		$this->egt_lng=htmlspecialchars(strip_tags($this->egt_lng));
		$this->cpt_id=htmlspecialchars(strip_tags($this->cpt_id));
		$this->egt_id=htmlspecialchars(strip_tags($this->egt_id));
	 
		// bind new values
		$stmt->bindParam(':egt_dateheure', $this->egt_dateheure);
		$stmt->bindParam(':egt_pm25', $this->egt_pm25);
		$stmt->bindParam(':egt_pm10', $this->egt_pm10);
		$stmt->bindParam(':egt_o3', $this->egt_o3);
		$stmt->bindParam(':egt_no2', $this->egt_no2);
		$stmt->bindParam(':egt_co', $this->egt_co);
		$stmt->bindParam(':egt_p', $this->egt_p);
		$stmt->bindParam(':egt_temperature', $this->egt_temperature);
		$stmt->bindParam(':egt_lng', $this->egt_lng);
		$stmt->bindParam(':egt_lng', $this->egt_lng);
		$stmt->bindParam(':cpt_id', $this->cpt_id);
		$stmt->bindParam(':egt_id', $this->egt_id);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	// delete the enregistrement
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE egt_id = ?";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->egt_id=htmlspecialchars(strip_tags($this->egt_id));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->egt_id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
}

?>