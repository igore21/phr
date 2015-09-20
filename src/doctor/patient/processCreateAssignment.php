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

if (isset($_POST['assignment_id'])) $assignment['assignment_id'] = $_POST['assignment_id'];
if (!empty($_POST['patient_id'])) $assignment['patient_id'] = $_POST['patient_id'];
if (!empty($_POST['name'])) $assignment['name'] = $_POST['name'];
if (!empty($_POST['description'])) $assignment['description'] = $_POST['description'];
if (!empty($_POST['start_time'])) $assignment['start_time'] = $_POST['start_time'];
if (!empty($_POST['end_time'])) $assignment['end_time'] = $_POST['end_time'];
if (!empty($_POST['params'])) {
	$assignment['params'] = $_POST['params'];
	unset($assignment['params'][0]);
	foreach ($assignment['params'] as $index => $param)
		$assignment['params'][$index]['mandatory'] = isset($param['mandatory']) ? $param['mandatory'] : '0';
}

$_SESSION['new_assignment'] = $assignment;
unset($_SESSION['createAssignmentError']);

$requiredParams = array(
	'assignment_id',
	'patient_id',
	'name',
	'start_time',
	'end_time',
	'params',
);

$missingParams = array_diff(array_values($requiredParams), array_keys($assignment));
if (!empty($missingParams)) {
	$_SESSION['createAssignmentError'] = 'Nedostaju obavezni parametri. Parametri: ' . implode(',', $missingParams);
}
if ($assignment['start_time'] >= $assignment['end_time']) {
	$_SESSION['createAssignmentError'] = 'Vreme pocetka zadatka mora biti vece od vremena kraja';
}

if (!empty($_SESSION['createAssignmentError'])) {
	$params = array();
	if (!empty($_POST['patient_id'])) { $params['user_id'] = $_POST['patient_id']; }
	if (!empty($_POST['assignment_id'])) {
		$params['assignment_id'] = $_POST['assignment_id'];
		redirect('editAssignment.php', $params);
	}
	redirect('createAssignment.php', $params);
}

$isNewAssignment = $assignment['assignment_id'] == 0;
$allParameters = DB::getAllParameters();

$scheduledData = getScheduledTasks($assignment, $allParameters, $isNewAssignment);
if ($scheduledData == null) redirect('/index.php');

try {
	if ($isNewAssignment) {
		$assignment['assignment_id'] = DB::createAssignment($assignment);
	} else {
		DB::updateAssignment($assignment);
		DB::deleteData($assignment['assignment_id']);
	}
	
	foreach ($scheduledData as $index => $dataRow) {
		$scheduledData[$index]['assignment_id'] = $assignment['assignment_id'];
	}
	
	DB::insertAssignmentData($scheduledData);
} catch (Exception $e) {
	$_SESSION['createAssignmentError'] = 'Greska: ' . $e->getMessage();
	redirect('/doctor/patient/createAssignment.php', array('user_id' => $assignment['patient_id']));
}

unset($_SESSION['new_assignment']);
$_SESSION['createAssignmentSuccess'] = true;
redirect('/doctor/patient/assignmentsPatient.php', array('user_id' => $assignment['patient_id']));

