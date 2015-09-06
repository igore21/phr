<?php
require_once '../../DB.php';
require_once '../../common.php';
require_once '../../constants.php';

$role = getUserRole();
if ($role != DOCTOR_ROLE) {
	redirect('login.php');
}

$doctorId = $_SESSION['user']['id'];

$missingParam = empty($_POST['patient_id']) ||
				empty($_POST['name']) ||
				empty($_POST['description']) ||
				empty($_POST['start_time']) ||
				empty($_POST['end_time']) ||
				empty($_POST['time_between']) ||
				empty($_POST['period']) ||
				empty($_POST['max_delay']) ||
				empty($_POST['paramIds']);

if ($missingParam) {
	$_SESSION['createAssignmentError'] = 'Nisu svi parametri prosledjeni';
	$params = array();
	if (!empty($_POST['patient_id'])) { $params['user_id'] = $_POST['patient_id']; }
	redirect('createAssignment.php', $params);
}

$assignment = array(
	'patient_id' => $_POST['patient_id'],
	'doctor_id' => $doctorId,
	'name' => $_POST['name'],
	'description' => $_POST['description'],
	'start_time' => $_POST['start_time'],
	'end_time' => $_POST['end_time'],
	'time_between' => $_POST['time_between'],
	'period' => $_POST['period'],
	'max_delay' => $_POST['max_delay'],
	'comment' => $_POST['comment'],
	'paramIds' => $_POST['paramIds'],
);

unset($assignment['paramIds'][0]);

$frequency = 1;
if ($assignment['period'] == PERIOD_HOURS) { $frequency = $_POST['time_between']; }
if ($assignment['period'] == PERIOD_DAYS) { $frequency = $_POST['time_between']*24; }
if ($assignment['period'] == PERIOD_WEEKS) { $frequency = $_POST['time_between']*7*24; }
$assignment['frequency'] = $frequency;

$_SESSION['new_assignment'] = $assignment;

try {
	$success = DB::createAssignment($assignment);
} catch (Exception $e) {
	$_SESSION['createAssignmentError'] = 'Greska: ' . $e->getMessage();
	redirect('/doctor/patient/createAssignment.php', array('user_id' => $assignment['patient_id']));
}

$_SESSION['createAssignmentSuccess'] = true;
redirect('/doctor/patient/assignmentsPatient.php', array('user_id' => $assignment['patient_id']));

