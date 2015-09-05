<?php
require_once '../DB.php';
require_once '../common.php';
require_once '../constants.php';

try {
	if (empty($_POST['op']) || empty($_POST['np'])) {
		throw Exception('Greska u prosledjenim parametrima.');
	}

	$output = array('success' => true);
	session_start();
	$user = $_SESSION['user'];
	$oldPassword = $_POST['op'];
	$newPassword = $_POST['np'];
	
	$users = DB::getUser(array('id' => $user['id']));
	if (empty($user)) throw Exception('Doslo je do greske');
	
	$user = $users[0];
	if (!($user['password'] === $oldPassword)) {
		throw new Exception('Trenutna sifra nije ispravna.');
	}
	
	$success = DB::changePassword($newPassword, $user['id']);
	if (empty($success)) {
		throw new Exception('Doslo je do greske prilikom upisa u bazu.');
	}

} catch (Exception $e) {
	$output['error'] = $e->getMessage();
}
echo json_encode($output);
