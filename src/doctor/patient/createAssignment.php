<?php
require_once '../../common.php';
require_once '../../DB.php';
require '../../header.php';

if (empty($_GET['user_id'])) {
	redirect('/doctor/search.php');
}

$patientId = $_GET['user_id'];
$patient = DB::getUser(array('user_id' => $patientId));
if (empty($patient)) {
	redirect('/doctor/search.php');
}

$assignment = array(
	'id' => 0,
	'patient_id' => $patientId,
	'name' => '',
	'description' => '',
	'start_time' => '',
	'end_time' => '',
	'params' => array(),
);

$tableTitle = "Napravite novi zadatak";
$buttonName = "Napravi Zadatak";

include 'createEditAssignmentForm.php';

require '../../footer.php';
