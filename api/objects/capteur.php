<?php
class Capteur{
 
    // database connection and table name
    private $conn;
    private $table_name = "CAPTEUR";
 
    // object properties
    public $cpt_id;
    public $cpt_nom;
    public $usr_id;
    public $usr_nom;
    public $usr_prenom;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	// read capteurs
	function read(){
	 
		// select all query
		$query = "SELECT
					c.cpt_id, c.cpt_nom, c.usr_id, u.usr_nom, u.usr_prenom
				FROM
					" . $this->table_name . " c
					LEFT JOIN
						UTILISATEUR u
							ON c.usr_id = u.usr_id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	// create capteur
	function create(){
	 // query to insert record
		$query = "INSERT INTO 
					" . $this->table_name . " 
				SET
					cpt_nom=:cpt_nom, usr_id=:usr_id";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->cpt_nom=htmlspecialchars(strip_tags($this->cpt_nom));
		$this->usr_id=htmlspecialchars(strip_tags($this->usr_id));
	 
		// bind values
		$stmt->bindParam(":cpt_nom", $this->cpt_nom);
		$stmt->bindParam(":usr_id", $this->usr_id);
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;	 
	}	
	
	// used when filling up the update capteur form
	function readOne(){
	 
		// query to read single record
		$query = "SELECT 
					c.cpt_id, c.cpt_nom, c.usr_id, u.usr_nom, u.usr_prenom
				FROM
					" . $this->table_name . " c
					LEFT JOIN
						UTILISATEUR u
							ON c.usr_id = u.usr_id
				WHERE
					cpt_id = ?";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of utilisateur to be updated
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		// set values to object properties
		$this->cpt_nom = $row['cpt_nom'];
		$this->usr_id = $row['usr_id'];
		$this->usr_nom = $row['usr_nom'];
		$this->usr_prenom = $row['usr_id'];
	}
	
	// update the capteur
	function update(){
	 
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					cpt_nom=:cpt_nom,
					usr_id=:usr_id
				WHERE
					cpt_id=:cpt_id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->cpt_nom=htmlspecialchars(strip_tags($this->cpt_nom));
		$this->usr_id=htmlspecialchars(strip_tags($this->usr_id));
		$this->cpt_id=htmlspecialchars(strip_tags($this->cpt_id));
	 
		// bind new values
		$stmt->bindParam(':cpt_nom', $this->cpt_nom);
		$stmt->bindParam(':usr_id', $this->usr_id);
		$stmt->bindParam(':cpt_id', $this->cpt_id);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}

	// delete the capteur
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE cpt_id = ?";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->cpt_id=htmlspecialchars(strip_tags($this->cpt_id));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->cpt_id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}

}
	
?>