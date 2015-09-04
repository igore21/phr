<?php
require_once '../DB.php';
require_once '../common.php';
require_once '../constants.php';
getUserRole();
$sesion = $_SESSION;
$ID = $sesion['user']['id'];
$oldPassword = $_POST['op'];
$newPassword = $_POST['np'];

$output = array();

$user = DB::getUserById($ID);
$password = $user['password'];

if (!($password === $oldPassword) || empty($_POST['op']) || empty($_POST['np'])) {
	$output = array('error' => 'doslo je do greske');
	echo json_encode($output);
	return;
}

try {
	$success = DB::changePassword($newPassword, $ID);
	if (empty($success)) {
		$output = array('error' => 'doslo je do greske');
	}
}

catch (Exception $e) {
	$output = array('error' => 'doslo je do greske');
}

echo json_encode($output);
