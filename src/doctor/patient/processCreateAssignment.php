<?php
require_once '../../DB.php';
require_once '../../common.php';
require_once '../../constants.php';

$role = getUserRole();
if ($role != DOCTOR_ROLE) {
	redirect('login.php');
}

$doctorId = $_SESSION['user']['id'];

$assignment = array(
	'doctor_id' => $doctorId,
	'description' => '',
	'comment' => '',
);

if (!empty($_POST['patient_id'])) $assignment['patient_id'] = $_POST['patient_id'];
if (!empty($_POST['name'])) $assignment['name'] = $_POST['name'];
if (!empty($_POST['description'])) $assignment['description'] = $_POST['description'];
if (!empty($_POST['start_time'])) $assignment['start_time'] = $_POST['start_time'];
if (!empty($_POST['end_time'])) $assignment['end_time'] = $_POST['end_time'];
if (!empty($_POST['time_between'])) $assignment['time_between'] = $_POST['time_between'];
if (!empty($_POST['period'])) $assignment['period'] = $_POST['period'];
if (!empty($_POST['paramIds'])) {
	$assignment['paramIds'] = $_POST['paramIds'];
	unset($assignment['paramIds'][0]);
}

$_SESSION['new_assignment'] = $assignment;

$missingParam = empty($assignment['patient_id']) ||
				empty($assignment['name']) ||
				empty($assignment['start_time']) ||
				empty($assignment['end_time']) ||
				empty($assignment['time_between']) ||
				empty($assignment['period']) ||
				empty($assignment['paramIds']);
	
if ($missingParam) {
	$_SESSION['createAssignmentError'] = 'Nisu svi parametri prosledjeni';
	$params = array();
	if (!empty($_POST['patient_id'])) { $params['user_id'] = $_POST['patient_id']; }
	redirect('createAssignment.php', $params);
}

$frequency = 1;
if ($assignment['period'] == PERIOD_HOURS) { $frequency = $_POST['time_between']; }
if ($assignment['period'] == PERIOD_DAYS) { $frequency = $_POST['time_between']*24; }
if ($assignment['period'] == PERIOD_WEEKS) { $frequency = $_POST['time_between']*7*24; }
$assignment['frequency'] = $frequency;

try {
	$success = DB::createAssignment($assignment);
} catch (Exception $e) {
	$_SESSION['createAssignmentError'] = 'Greska: ' . $e->getMessage();
	redirect('/doctor/patient/createAssignment.php', array('user_id' => $assignment['patient_id']));
}

$_SESSION['createAssignmentSuccess'] = true;
redirect('/doctor/patient/assignmentsPatient.php', array('user_id' => $assignment['patient_id']));

