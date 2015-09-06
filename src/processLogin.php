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

$user = DB::getUser(array('email' => $email));

if (!empty($user) && $user['password'] == $password) {
	$_SESSION['user'] = $user;
	redirect('/index.php');
}
else {
	$_SESSION['loginError'] = 'Pogresan Email ili sifra';
	redirect('login.php');
}
