<?php

$_POST = json_decode(file_get_contents('php://input'), true);

include_once '../db.php';

header("Content-Type: application/json");
$con = new pdo_db("offenses");


$_POST['offense']['student_no'] = $_POST['offense']['student_no']['student_id'];
if (isset($_POST['offense']['inc_uniform'],$_POST['offense']['late_tardy'],$_POST['offense']['absent'],$_POST['offense']['no_id'],$_POST['offense']['cutting_classes'],$_POST['offense']['recom_others_cb'],$_POST['offense']['recom_others_cb'],$_POST['offense']['recommendation']))    
{    
	$_POST['offense']['inc_uniform'] = ($_POST['offense']['inc_uniform'])?1:0; 
	$_POST['offense']['late_tardy'] = ($_POST['offense']['late_tardy'])?1:0;	
	$_POST['offense']['absent'] = ($_POST['offense']['absent'])?1:0;		
	$_POST['offense']['no_id'] = ($_POST['offense']['no_id'])?1:0;	
	$_POST['offense']['cutting_classes'] = ($_POST['offense']['cutting_classes'])?1:0;
	$_POST['offense']['recommendation'] = ($_POST['offense']['recommendation'])?1:0;
	$_POST['offense']['check_others'] = ($_POST['offense']['check_others'])?1:0;
	$_POST['offense']['recom_others_cb'] = ($_POST['offense']['recom_others_cb'])?1:0;
}

$_POST['offense']['offs_date'] =  date("Y-m-d",strtotime($_POST['offense']['offs_date']));

if ($_POST['offense']['offense_id']) {
	
	$offense = $con->updateData($_POST['offense'],'offense_id');
	
} else {
	
	$offense = $con->insertData($_POST['offense']);
	echo $con->insertId;

}

?>