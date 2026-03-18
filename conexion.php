<?php
    class db{
        private $host = "localhost";
        private $dbname = "hospital_pro";
        private $user = "root";
        private $pass = "";

        public function conexion(){
            try {
                $pdo = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->pass);
                return $pdo;
            } catch (PDOException $e) {
                error_log("Error de conexión: " . $e->getMessage());
                return null;
            }
        }
    }