<?php

$_POST = json_decode(file_get_contents('php://input'), true);

include_once '../db.php';

header("Content-Type: application/json");
$con = new pdo_db("offenses");


$_POST['offense']['student_no'] = $_POST['offense']['student_no']['student_id'];
if (isset($_POST['offense']['inc_uniform'],$_POST['offense']['late_tardy'],$_POST['offense']['absent'],$_POST['offense']['no_id'],$_POST['offense']['cutting_classes'],$_POST['offense']['recom_others_cb'],$_POST['offense']['recom_others_cb'],$_POST['offense']['check_others'],$_POST['offense']['admitted_excuse'],$_POST['offense']['admitted_notexcuse'],$_POST['offense']['academic_loses'],$_POST['offense']['completion_required'],$_POST['offense']['dropped'],$_POST['offense']['parent_notification'],$_POST['offense']['done']))    
{    
	$_POST['offense']['inc_uniform'] = ($_POST['offense']['inc_uniform'])?1:0; 
	$_POST['offense']['late_tardy'] = ($_POST['offense']['late_tardy'])?1:0;	
	$_POST['offense']['absent'] = ($_POST['offense']['absent'])?1:0;		
	$_POST['offense']['no_id'] = ($_POST['offense']['no_id'])?1:0;	
	$_POST['offense']['cutting_classes'] = ($_POST['offense']['cutting_classes'])?1:0;
	$_POST['offense']['check_others'] = ($_POST['offense']['check_others'])?1:0;
	$_POST['offense']['admitted_excuse'] = ($_POST['offense']['admitted_excuse'])?1:0;
	$_POST['offense']['admitted_notexcuse'] = ($_POST['offense']['admitted_notexcuse'])?1:0;
	$_POST['offense']['academic_loses'] = ($_POST['offense']['academic_loses'])?1:0;
	$_POST['offense']['completion_required'] = ($_POST['offense']['completion_required'])?1:0;
	$_POST['offense']['dropped'] = ($_POST['offense']['dropped'])?1:0;
	$_POST['offense']['parent_notification'] = ($_POST['offense']['parent_notification'])?1:0;
	$_POST['offense']['recom_others_cb'] = ($_POST['offense']['recom_others_cb'])?1:0;
	$_POST['offense']['done'] = ($_POST['offense']['done'])?1:0;
	// if ($_POST['offense']['done'] == true) { $_POST['offense']['com_service'] == "0";}
	
}



// $_POST['offense']['offs_date'] =  date("Y-m-d",strtotime($_POST['offense']['offs_date']));
$_POST['offense']['recom_date'] =  date("Y-m-d",strtotime($_POST['offense']['recom_date']));

if ($_POST['offense']['offense_id']) {
	
	$offense = $con->updateData($_POST['offense'],'offense_id');
	


} else {
	
	

	$offense = $con->insertData($_POST['offense']);
	echo $con->insertId;

}

?>