<?php
require_once '../DB.php';
require_once '../common.php';

if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password'])) {
	redirect('createAccount.php');
}

try {
	$userRole = getUserRole();
	if ($userRole != DOCTOR_ROLE) {
		redirect('/index.php');
	}
	
	unset($_SESSION['createAccountError']);
	
	$account = array (
		'first_name' => $_POST['first_name'],
		'last_name' => $_POST['last_name'],
		'file_id' => $_POST['file_id'],
		'email' => $_POST['email'],
		'password' => $_POST['password'],
		'role' => PACIENT_ROLE,
	);
	$_SESSION['createAccountData'] = $account;
	
	$users = DB::getUser(array('email' => $account['email']));
	if (!empty($users)) throw new Exception('Korisinik sa zadatim email-om vec postoji u bazi.');
	
	$users = DB::getUser(array('file_id' => $account['file_id']));
	if (!empty($users)) throw new Exception('Korisinik sa zadatim brojem kartona vec postoji u bazi.');
	
	$success = DB::createUser($account);
	if (empty($success)) {
		throw new Exception('Greska prilikom upisa u bazu.');
	}
	
	unset($_SESSION['createAccountData']);
	redirect('/doctor/createAssignment.php');
} 
catch (Exception $e) {
	$_SESSION['createAccountError'] = $e->getMessage();
}

redirect('/doctor/createAccount.php');
