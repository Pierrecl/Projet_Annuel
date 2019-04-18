<?php
class Database{
 
    // specify your own database credentials
    private $host = "remotemysql.com";
    private $db_name = "NqsCz4L937";
    private $username = "NqsCz4L937";
    private $password = "D4TJm9uyjD";
	//private $host = "localhost";
	//private $db_name = "polluviz";
	//private $username = "root";
	//private $password = "";
	
	private $port = "3306";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>