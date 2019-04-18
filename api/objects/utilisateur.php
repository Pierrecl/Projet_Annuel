<?php
class Utilisateur{
 
    // database connection and table name
    private $conn;
    private $table_name = "UTILISATEUR";
 
    // object properties
    public $usr_id;
    public $usr_nom;
    public $usr_prenom;
    public $usr_datecreation;
    public $usr_type;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

	// read utilisateurs
	function read(){
	 
		// select all query
		$query = "SELECT
					usr_id, usr_nom, usr_prenom, usr_datecreation, usr_type
				FROM
					" . $this->table_name ;
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	// create utilisateur
	function create(){
	 // query to insert record
		$query = "INSERT INTO 
					" . $this->table_name . " 
				SET
					usr_nom=:usr_nom, usr_prenom=:usr_prenom, usr_datecreation=:usr_datecreation, usr_type=:usr_type";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->usr_nom=htmlspecialchars(strip_tags($this->usr_nom));
		$this->usr_prenom=htmlspecialchars(strip_tags($this->usr_prenom));
		$this->usr_datecreation=htmlspecialchars(strip_tags($this->usr_datecreation));
		$this->usr_type=htmlspecialchars(strip_tags($this->usr_type));
	 
		// bind values
		$stmt->bindParam(":usr_nom", $this->usr_nom);
		$stmt->bindParam(":usr_prenom", $this->usr_prenom);
		$stmt->bindParam(":usr_datecreation", $this->usr_datecreation);
		$stmt->bindParam(":usr_type", $this->usr_type);
		// execute query
		if($stmt->execute()){
			return true;
		}
		return false;	 
	}
	
	// used when filling up the update utilisateur form
	function readOne(){
	 
		// query to read single record
		$query = "SELECT 
					usr_id, usr_nom, usr_prenom, usr_datecreation, usr_type
				FROM
					" . $this->table_name . "
				WHERE
					usr_id = ?";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of utilisateur to be updated
		$stmt->bindParam(1, $this->id);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		// set values to object properties
		$this->usr_nom = $row['usr_nom'];
		$this->usr_prenom = $row['usr_prenom'];
		$this->usr_datecreation = $row['usr_datecreation'];
		$this->usr_type = $row['usr_type'];
	}
	
	// update the utilisateur
	function update(){
	 
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					usr_nom=:usr_nom,
					usr_prenom=:usr_prenom,
					usr_datecreation=:usr_datecreation,
					usr_type=:usr_type
				WHERE
					usr_id=:usr_id";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->usr_nom=htmlspecialchars(strip_tags($this->usr_nom));
		$this->usr_prenom=htmlspecialchars(strip_tags($this->usr_prenom));
		$this->usr_datecreation=htmlspecialchars(strip_tags($this->usr_datecreation));
		$this->usr_type=htmlspecialchars(strip_tags($this->usr_type));
		$this->usr_id=htmlspecialchars(strip_tags($this->usr_id));
	 
		// bind new values
		$stmt->bindParam(':usr_nom', $this->usr_nom);
		$stmt->bindParam(':usr_prenom', $this->usr_prenom);
		$stmt->bindParam(':usr_datecreation', $this->usr_datecreation);
		$stmt->bindParam(':usr_type', $this->usr_type);
		$stmt->bindParam(':usr_id', $this->usr_id);
		
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	// delete the utilisateur
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE usr_id = ?";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->usr_id=htmlspecialchars(strip_tags($this->usr_id));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->usr_id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
}

?>