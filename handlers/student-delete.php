<?php

$_POST = json_decode(file_get_contents('php://input'), true);

require_once '../db.php';

session_start();
header("Content-Type: application/json");
$con = new pdo_db("students");

$delete = $con->deleteData(array("student_id"=>implode(",",$_POST['student_id'])));	

$pictures = array("front");

foreach ($_POST['student_id'] as $student_id) {
	
	foreach($pictures as $picture) {
		
		$file = "../pictures/".$student_id."_".$picture.".png";
		if (file_exists($file)) unlink($file);
		
	}
	
};

?>