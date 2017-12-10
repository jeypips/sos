<?php

$_POST = json_decode(file_get_contents('php://input'), true);

include_once '../db.php';

header("Content-Type: application/json");
$con = new pdo_db("students");

// $_POST['detainee_info']['detainee_city_address'] = $_POST['detainee_info']['detainee_city_address']['id'];
$_POST['student']['date'] =  date("Y-m-d",strtotime($_POST['student']['date']));

if ($_POST['student']['student_id']) {
	
	$student = $con->updateData($_POST['student'],'student_id');
	
} else {
	
	$student = $con->insertData($_POST['student']);
	echo $con->insertId;

}

?>