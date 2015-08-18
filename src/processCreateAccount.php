<?php
require_once 'DB.php';
require_once 'common.php';

if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
	redirect('createAccount.php');
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$role = $_POST['role'];
var_dump($_POST);
try {
	$success = DB::createUser($first_name, $last_name, $email, $password, $role);	
	var_dump($success);
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