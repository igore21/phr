<?php
require_once 'DB.php';
require_once 'common.php';

if (getUserRole() != ANONYMOUS_ROLE) {
	redirect('index.php');
}

if (empty($_POST['usermail']) || empty($_POST['password'])) {
	redirect('login.php');
}

$mail = $_POST['usermail'];
$password = $_POST['password'];

$user = DB::getUserByMail($mail);


if (!empty($user) && $user['password'] == $password) {
	$_SESSION['user'] = $user;
	$r = getUserRole();
	if ($r == PACIENT_ROLE) redirect('/doctor/search.php');
	if ($r == DOCTOR_ROLE) redirect('/doctor/search.php');
}
else {
	$_SESSION['loginError'] = 'Pogresan Email ili sifra';
	redirect('login.php');
}
