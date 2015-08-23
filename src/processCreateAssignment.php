<?php

require_once 'DB.php';
require_once 'common.php';
require_once 'constants.php';

$role = getUserRole();
$userId = $_SESSION['user']['id'];

 

if ($role!=2) {
	redirect('login.php');
}

if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['description']) || empty($_POST['actions']) || empty($_POST['start_time'])
		 || empty($_POST['end_time']) || empty($_POST['max_delay']) || empty($_POST['comment'])) {
	redirect('createAccount.php');
}

$assignment = array(
		'email' => $_POST['email'],
		'name' => $_POST['name'],
		'description' => $_POST['description'],
		'actions' => $_POST['actions'],
		'start_time' => $_POST['start_time'],
		'end_time' => $_POST['end_time'],
		'time_between' => $_POST['time_between'],
		'max_delay' => $_POST['max_delay'],
		'comment' => $_POST['comment'],
);

$nadjen_mail = false;
if ($pacient = DB::getUserByMail($_POST['email'])) {
	$nadjen_mail = true;
	$pacient_id = $pacient['id'];
}

$doctor_id = $userId;
$period = $_POST['period'];
$frequency = null;

if ($_POST['period']==PERIOD_HOURS) {$frequency = $_POST['time_between'];}
if ($_POST['period']==PERIOD_DAYS) {$frequency = $_POST['time_between']*24;}
if ($_POST['period']==PERIOD_WEEKS) {$frequency = $_POST['time_between']*7*24;}


$_SESSION['new_assignment'] = $assignment;
$assignment['frequency'] = $frequency;
$assignment['doctor_id'] = $doctor_id;
$assignment['pacient_id'] = $pacient_id;

try {
	$success = DB::createAssignment($assignment);
	//var_dump($success);
}

catch (Exception $e) {
	echo 'pukla baza';
	//TODO uradi...
}



$b = DB::getAssignmentId($assignment);
$sid = ($b[count($b)-1]);
unset($_POST['paramIds'][0]);
$parameters = $_POST['paramIds'];
var_dump(count($parameters));
var_dump($parameters);
 //var_dump($_POST['paramIds']);
// return;

// $parameters = $_POST['param'];
// var_dump($parameters);
$assignmentId = $sid['id'];
 var_dump($sid['id']);
// $paramet['assignment_id'] = $sid['id'];
// $paramet['parameter_id'] = $parameters;
try {
	$succ = DB::addParameter($parameters, $assignmentId);
	var_dump($succ);
}

catch (Exception $e) {
	echo 'pukla baza';
	//TODO uradi...
}

//var_dump($pacient);
$r = $pacient['role'];
if ($r!=1) {
	$_SESSION['createAssignmentError'] = 'email ne pripada osobi koja je pacijent';
	redirect('createAssignment.php');
}
if (!$nadjen_mail) {
	$_SESSION['createAssignmentError'] = 'email nije pronadjen u bazi';
	redirect('createAssignment.php');
	
}

// $_POST[] = array(
// 		'tree' => array(
// 				'tree1'=>array(
// 						'fruit'=>'value',
// 						'height'=>'value'
// 				),
// 				'tree2'=>array(
// 						'fruit'=>'value',
// 						'height'=>'value'
// 				),
// 				'tree3'=>array(
// 						'fruit'=>'value',
// 						'height'=>'value'
// 				)
// 		)
// )

if ($success) {
	echo 'ok';
	unset($_SESSION['new_assignment']);
	//TODO redirektovanje na novu stranicu, kad je napravim
}
else {
	echo 'nije';
}


?>