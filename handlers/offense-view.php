<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();

$con = new pdo_db();
$offense = $con->getData("SELECT * FROM offenses WHERE offense_id = $_POST[offense_id]");
$student = $con->getData("SELECT *, CONCAT(lastname,',',' ',firstname,' ', middlename) fullname FROM students WHERE student_id = ".$offense[0]['student_no']);
$offense[0]['inc_uniform'] = ($offense[0]['inc_uniform'])?true:false;
$offense[0]['late_tardy'] = ($offense[0]['late_tardy'])?true:false;
$offense[0]['absent'] = ($offense[0]['absent'])?true:false;
$offense[0]['no_id'] = ($offense[0]['no_id'])?true:false;
$offense[0]['cutting_classes'] = ($offense[0]['cutting_classes'])?true:false;
$offense[0]['check_others'] = ($offense[0]['check_others'])?true:false;
$offense[0]['recom_others_cb'] = ($offense[0]['recom_others_cb'])?true:false;
$offense[0]['admitted_excuse'] = ($offense[0]['admitted_excuse'])?true:false;
$offense[0]['admitted_notexcuse'] = ($offense[0]['admitted_notexcuse'])?true:false;
$offense[0]['academic_loses'] = ($offense[0]['academic_loses'])?true:false;
$offense[0]['completion_required'] = ($offense[0]['completion_required'])?true:false;
$offense[0]['dropped'] = ($offense[0]['dropped'])?true:false;
$offense[0]['parent_notification'] = ($offense[0]['parent_notification'])?true:false;
$offense[0]['done'] = ($offense[0]['done'])?true:false;
$offense[0]['student_no'] = $student[0];

header("Content-Type: application/json");
echo json_encode($offense[0]);

?>