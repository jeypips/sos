<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();

$con = new pdo_db();

$students = $con->getData("SELECT *, MAX(student_id) student_id FROM students");

header("Content-Type: application/json");
echo json_encode($students);

?>