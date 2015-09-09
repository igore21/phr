<?php
require_once '../../common.php';
require_once '../../DB.php';
require '../../header.php';

if (empty($_GET['user_id']) || empty($_GET['assignment_id'])) {
	redirect('/doctor/search.php');
}

$patientId = $_GET['user_id'];
$patient = DB::getUser(array('user_id' => $patientId));
$assignmentId = $_GET['assignment_id'];
$assignment = DB::getAssignment($assignmentId);
if (empty($assignment) || empty($patient) || $assignment['patient_id'] != $patientId) {
	redirect('/doctor/search.php');
}

$tableTitle = "Detalji zadatka";
$buttonName = "Izmeni Zadatak";

include 'createEditAssignmentForm.php';

require '../../footer.php';