<?php
    class Contact{

        // Connection
        private $conn;

        // Table
        private $db_table = "contact";

        // Columns
        public $id;
        public $fullname;
        public $email;
        public $subject;
        public $message;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getContacts(){
            $sqlQuery = "SELECT id, fullname, email, subject, message, created_at FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createContact(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        fullname = :fullname, 
                        email = :email, 
                        subject = :subject, 
                        message = :message";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->fullname=htmlspecialchars(strip_tags($this->fullname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->subject=htmlspecialchars(strip_tags($this->subject));
            $this->message=htmlspecialchars(strip_tags($this->message));
        
            // bind data
            $stmt->bindParam(":fullname", $this->fullname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":subject", $this->subject);
            $stmt->bindParam(":message", $this->message);
        
            if($stmt->execute()){
               return true;
            }
            
            return false;
        }
    }
?>
