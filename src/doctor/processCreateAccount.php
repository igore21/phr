<?php
require_once '../DB.php';
require_once '../common.php';

if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password'])) {
	redirect('createAccount.php');
}

$account = array (
	'first_name' => $_POST['first_name'],
	'last_name' => $_POST['last_name'],
	'file_id' => $_POST['file_id'],
	'email' => $_POST['email'],
	'password' => $_POST['password'],
	'role' => 1,
);
//$role = 1;
//var_dump($_POST);
try {
	$success = DB::createUser($account);	
	var_dump($success);
	redirect('createAccount.php');
} 
catch (Exception $e) {
	echo 'pukla baza';
	//TODO uradi...
}

if ($success) {
	echo 'ok';
	//TODO redirektovanje na novu stranicu, kad je napravim
}
else {
	echo 'nije';
}


?>