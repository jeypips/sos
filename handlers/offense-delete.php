<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();
header("Content-Type: application/json");
$con = new pdo_db("offenses");

$delete = $con->deleteData(array("offense_id"=>implode(",",$_POST['offense_id'])));	

?>