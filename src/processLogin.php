<?php
require_once 'DB.php';
require_once 'common.php';

if (getUserRole() != ANONYMOUS_ROLE) {
	redirect('index.php');
}

if (empty($_POST['usermail']) || empty($_POST['password'])) {
	redirect('login.php');
}

$email = $_POST['usermail'];
$password = $_POST['password'];

$users = DB::getUser(array('email' => $email));

if (!empty($users) && $users[0]['password'] == $password) {
	$_SESSION['user'] = $users[0];
	redirect('/index.php');
}
else {
	$_SESSION['loginError'] = 'Pogresan Email ili sifra';
	redirect('login.php');
}
