<?php
require_once '../DB.php';
require_once '../common.php';
require_once '../constants.php';

$output = array();
try {
	
	if (empty($_POST['fn']) || empty($_POST['ln']) || empty($_POST['em'])) {
		throw new Exception('Greska u prosledjenim parametrima.');
	}
	
	$output = array('success' => true);
	session_start();
	$user = $_SESSION['user'];
	
	$newUser = array(
		'first_name' => $_POST['fn'],
		'last_name' => $_POST['ln'],
		'email' => $_POST['em'],
	);
	
	$success = DB::editUser($newUser, $user['id']);
	if (!$success) {
		throw new Exception('Doslo je do greske prilikom upisa u bazu');
	}
	
	$user = array_replace($user, $newUser);
	$_SESSION['user'] = $user;
} catch (Exception $e) {
	$output['error'] = $e->getMessage();
}

echo json_encode($output);
