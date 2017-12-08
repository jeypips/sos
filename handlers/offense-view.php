<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();

$con = new pdo_db();

$offense = $con->getData("SELECT * FROM offenses WHERE offense_id = $_POST[offense_id]");

header("Content-Type: application/json");
echo json_encode($offense[0]);

?>