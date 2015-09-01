<?php
require_once '../DB.php';
require_once '../common.php';
require_once '../constants.php';
getUserRole();
$sesion = $_SESSION;
var_dump($sesion['user']['id']);

$oldPassword = $sesion['user']['password'];
$newPassword = $_POST['newPassword'];
var_dump($oldPassword);
var_dump($_POST);

$newUser = $_POST;
$ID = $sesion['user']['id'];

var_dump($ID);

if ($oldPassword == $_POST['password'] && $_POST['newPassword'] == $_POST['repeatNewPassword']) {

	try {
		$success = DB::changePassword($newPassword, $ID);
		var_dump($success);
		redirect('profile.php');
		//redirect('profile.php');
	}
	
	catch (Exception $e) {
		echo 'pukla baza';
		//TODO uradi...
	}
	
	if ($success) {
		//$_SESSION.destroy();
		redirect('profile.php');
		//TODO redirektovanje na novu stranicu, kad je napravim
	}
	else {
		echo 'nije';
	}
}





?>