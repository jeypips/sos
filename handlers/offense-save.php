<?php

$_POST = json_decode(file_get_contents('php://input'), true);

include_once '../db.php';

header("Content-Type: application/json");
$con = new pdo_db("offenses");

// $_POST['detainee_info']['detainee_city_address'] = $_POST['detainee_info']['detainee_city_address']['id'];
// $_POST['detainee_info']['detainee_birth_date'] =  date("Y-m-d",strtotime($_POST['detainee_info']['detainee_birth_date']));

if ($_POST['offense']['offense_id']) {
	
	$offense = $con->updateData($_POST['offense'],'offense_id');
	
} else {
	
	$offense = $con->insertData($_POST['offense']);
	echo $con->insertId;

}

?>