<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();

$con = new pdo_db();

$student = $con->getData("SELECT * FROM students WHERE student_id = $_POST[student_id]");

header("Content-Type: application/json");
echo json_encode($student[0]);

?>