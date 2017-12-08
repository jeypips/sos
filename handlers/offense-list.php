<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();

$con = new pdo_db();

$offenses = $con->getData("SELECT offense_id, firstname, lastname, middlename, educational_level, type, grade, section, year, course FROM students, offenses WHERE student_no = student_id");

header("Content-Type: application/json");
echo json_encode($offenses);

?>