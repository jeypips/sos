<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();

$con = new pdo_db();

$offenses = $con->getData("SELECT offense_id, student_id, id_number, firstname, lastname, middlename, educational_level, grade, section, year, course, inc_uniform, late_tardy, absent, no_id, cutting_classes, offs_date, recom_others_cb, IF(admitted_excuse=1,'To be admitted and be excuse','') admitted_excuse,IF(admitted_notexcuse=1,'To be admitted but NOT excuse','') admitted_notexcuse,IF(academic_loses=1,'To make up for any academic loses','') academic_loses,IF(completion_required=1,'To be admitted only after completion of what is required','') completion_required,IF(dropped=1,'To be dropped for incurring equivalent to 20% of total number of lecture/laboratory hours','') dropped,IF(parent_notification=1,'To send parents notification for conference','') parent_notification, recom_others FROM students, offenses WHERE student_no = student_id");


header("Content-Type: application/json");
echo json_encode($offenses);

?>