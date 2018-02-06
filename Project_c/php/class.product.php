<?php
require_once('dbconfig.php');

class product
{
    private $conn;
    public function __construct()
  	{
  		$database = new Database();
  		$db = $database->dbConnection();
  		$this->conn = $db;
    }
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }




}
?>
<!--
functions to be added
    change detail of product
    display product detail
