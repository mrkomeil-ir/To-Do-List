<?php
require_once "config.php";

class Database
{
    public $db;
    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host='.HOST.';dbname='.DBNAME,USERNAME,PASSWORD);
            $this->db->exec('SET NAMES utf8');
        }catch (Exception $e){
            throw new Exception("Error! not connect to Database.");
        }
    }
}