<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

$con = new pdo_db();

$student_id = $_POST['student_id'];

// $student = $con->getData("SELECT *, DATE_FORMAT(date, '%M %d, %Y') date, (SELECT SUM(com_service) plus FROM offenses, students WHERE student_no = student_id) total, DATE_FORMAT(offs_date, '%M %d, %Y') offs_date, inc_uniform, late_tardy, absent, no_id, cutting_classes, recom_others_cb, IF(inc_uniform=1,'No/Incomplete Uniform','') inc_uniform,IF(late_tardy=1,'Late/Tardy','') late_tardy,IF(absent=1,'Absent','') absent,IF(no_id=1,'No ID','') no_id,IF(cutting_classes=1,'Cutting Classes','') cutting_classes, others FROM students, offenses WHERE student_id = $_POST[student_id]");

$student = $con->getData("SELECT *, DATE_FORMAT(date, '%M %d, %Y') date, (SELECT SUM(com_service) plus FROM offenses, students WHERE student_no = student_id) total, DATE_FORMAT(offs_date, '%M %d, %Y') offs_date, inc_uniform, late_tardy, absent, no_id, cutting_classes, recom_others_cb, IF(inc_uniform=1,'No/Incomplete Uniform','') inc_uniform,IF(late_tardy=1,'Late/Tardy','') late_tardy,IF(absent=1,'Absent','') absent,IF(no_id=1,'No ID','') no_id,IF(cutting_classes=1,'Cutting Classes','') cutting_classes,IF(done=1,'Done','') done, others FROM students, offenses WHERE student_id = $_POST[student_id]");

foreach ($student[0] as $i => $p) {
	
	if ($p == null) $student[0][$i] = ""; // pdf equals null
	
}

header("Content-Type: application/json");
echo json_encode($student);

?>