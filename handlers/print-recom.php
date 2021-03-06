<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

$con = new pdo_db();

$offense_id = $_POST['offense_id'];

$offense = $con->getData("SELECT offense_id, CONCAT(lastname,',',' ',firstname,' ',middlename) fullname, student_no, inc_uniform, late_tardy, absent, no_id, cutting_classes, recom_others_cb, IF(inc_uniform=1,'No/Incomplete Uniform','') inc_uniform,IF(late_tardy=1,'Late/Tardy','') late_tardy,IF(absent=1,'Absent','') absent,IF(no_id=1,'No ID','') no_id,IF(cutting_classes=1,'Cutting Classes','') cutting_classes,IF(admitted_excuse=1,'To be admitted and be excuse','') admitted_excuse,IF(admitted_notexcuse=1,'To be admitted but NOT excuse','') admitted_notexcuse,IF(academic_loses=1,'To make up for any academic loses','') academic_loses,IF(completion_required=1,'To be admitted only after completion of what is required','') completion_required,IF(dropped=1,'To be dropped for incurring equivalent to 20% of total number of lecture/laboratory hours','') dropped,IF(parent_notification=1,'To send parents notification for conference','') parent_notification, IF(done=1,'Done!','') done, others, recom_others, DATE_FORMAT(recom_date, '%M %d, %Y') recom_date, (SELECT SUM(com_service) FROM offenses WHERE student_no = student_id) total FROM students, offenses WHERE offense_id = $_POST[offense_id] AND student_no = student_id");

foreach ($offense[0] as $i => $p) {
	
	if ($p == null) $offense[0][$i] = ""; // pdf equals null
	
}

header("Content-Type: application/json");
echo json_encode($offense);

?>