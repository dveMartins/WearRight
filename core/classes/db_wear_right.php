<?php

//Database Connection Constants

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'wear_right');

class Database {
    
    public $connection;
    
    function __construct() {
        $this->open_db_connection() ;
    }


    private function open_db_connection() {
        
    $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if($this->connection->connect_errno) {
        
        die("Database connection failed" . $this->connection->connect_error);
    }
    
   }
   
   public function query($sql) {
       
       $result = $this->connection->query($sql);
       $this->confirm_query($result);
       
       return $result;
   }
   
   public function confirm_query($result) {
       
       if(!$result) {
           die("Query Failed: " . $this->connection->connect_error);
       }
       
   }
   
   public function escape_string($string) {
       
       $escaped_string = $this->connection->real_escape_string(htmlspecialchars($string));
       return $escaped_string;
       
   }

}
// End of Database Classes

$database = new Database();


