<?php
require_once '../DB.php';
require_once '../common.php';
require_once '../constants.php';
getUserRole();
$sesion = $_SESSION;
$ID = $sesion['user']['id'];

if (empty($_POST['fn']) || empty($_POST['ln']) || empty($_POST['em'])) {
	$output = array('error' => 'doslo je do greske');
	echo json_encode($output);
	return;
}

$newUser = array(
	'first_name' => $_POST['fn'],
	'last_name' => $_POST['ln'],
	'email' => $_POST['em'],
);

$output = array('success' => 's');
try {
	$success = DB::editUser($newUser, $ID);
	if (empty($success)) {
		$output = array('error' => 'doslo je do greske');
	}
}

catch (Exception $e) {
	$output = array('error' => 'doslo je do greske');
}

echo json_encode($output);
