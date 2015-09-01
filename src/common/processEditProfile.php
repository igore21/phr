<?php
require_once '../DB.php';
require_once '../common.php';
require_once '../constants.php';
getUserRole();
$sesion = $_SESSION;
var_dump($sesion['user']['id']);


//var_dump($_POST);

$newUser = $_POST;
$ID = $sesion['user']['id'];
//var_dump($ID);

try {
	$success = DB::editUser($newUser, $ID);
	var_dump($success);
	//redirect('profile.php');
}

catch (Exception $e) {
	echo 'pukla baza';
	//TODO uradi...
}

if ($success) {
	//redirect('profile.php');
	//TODO redirektovanje na novu stranicu, kad je napravim
}
else {
	echo 'nije';
}






?>