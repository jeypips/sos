<?php

$_POST = json_decode(file_get_contents('php://input'), true);

include_once '../db.php';

header("Content-Type: application/json");
$con = new pdo_db("offenses");


$_POST['offense']['student_no'] = $_POST['offense']['student_no']['student_id'];
if (isset($_POST['inc_uniform']))    
{    
	$_POST['inc_uniform'] = ($_POST['inc_uniform'])?1:0; 
	$_POST['late_tardy'] = ($_POST['late_tardy'])?1:0;	
	/* $_POST['absent'] = ($_POST['absent'])?1:0;		
	$_POST['no_id'] = ($_POST['no_id'])?1:0;	
	$_POST['cutting_classes'] = ($_POST['cutting_classes'])?1:0;
	$_POST['cutting_classes'] = ($_POST['check_others'])?1:0; */
}

$_POST['offense']['offs_date'] =  date("Y-m-d",strtotime($_POST['offense']['offs_date']));

if ($_POST['offense']['offense_id']) {
	
	$offense = $con->updateData($_POST['offense'],'offense_id');
	
} else {
	
	$offense = $con->insertData($_POST['offense']);
	echo $con->insertId;

}

?>