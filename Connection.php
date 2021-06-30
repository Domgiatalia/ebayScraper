<?php

class Connection {
    private $db;

    function __construct() {
        $this->connect_database();
    }

    public function getInstance() {
        return $this->db;
    }

    private function connect_database(){
        $host       = '127.0.0.1'; //or localhost
        $database   = 'ebayitems';
        $port       = 3306;
        $user       = 'root';
        $password   = '';
        
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->db;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

};