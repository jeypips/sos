<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

$con = new pdo_db();

$student_id = $_POST['student_id'];

$student = $con->getData("SELECT *, DATE_FORMAT(date, '%M %d, %Y') date FROM students WHERE student_id = $_POST[student_id]");

foreach ($student[0] as $i => $p) {
	
	if ($p == null) $student[0][$i] = "N/A"; // pdf equals null
	
}

header("Content-Type: application/json");
echo json_encode($student);

?>