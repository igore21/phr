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
);

if (!empty($_POST['assignment_id'])) $assignment['assignment_id'] = $_POST['assignment_id'];
if (!empty($_POST['patient_id'])) $assignment['patient_id'] = $_POST['patient_id'];
if (!empty($_POST['name'])) $assignment['name'] = $_POST['name'];
if (!empty($_POST['description'])) $assignment['description'] = $_POST['description'];
if (!empty($_POST['start_time'])) $assignment['start_time'] = $_POST['start_time'];
if (!empty($_POST['end_time'])) $assignment['end_time'] = $_POST['end_time'];
if (!empty($_POST['params'])) {
	$assignment['params'] = $_POST['params'];
	unset($assignment['params'][0]);
}

$_SESSION['new_assignment'] = $assignment;

$missingParam = empty($assignment['assignment_id']) ||
				empty($assignment['patient_id']) ||
				empty($assignment['name']) ||
				empty($assignment['start_time']) ||
				empty($assignment['end_time']) ||
				empty($assignment['params']);

if ($missingParam) {
	$_SESSION['createAssignmentError'] = 'Nisu svi parametri prosledjeni';
	$params = array();
	if (!empty($_POST['patient_id'])) { $params['user_id'] = $_POST['patient_id']; }
	if (!empty($_POST['assignment_id'])) {
		$params['assignment_id'] = $_POST['assignment_id'];
		redirect('editAssignment.php', $params);
	}
	redirect('createAssignment.php', $params);
}

try {
	if ($assignment['assignment_id'] == 0) {
		DB::createAssignment($assignment);
	} else {
		DB::updateAssignment($assignment);
	}
} catch (Exception $e) {
	$_SESSION['createAssignmentError'] = 'Greska: ' . $e->getMessage();
	redirect('/doctor/patient/createAssignment.php', array('user_id' => $assignment['patient_id']));
}

unset($_SESSION['new_assignment']);
$_SESSION['createAssignmentSuccess'] = true;
redirect('/doctor/patient/assignmentsPatient.php', array('user_id' => $assignment['patient_id']));

