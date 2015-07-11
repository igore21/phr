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


if ($user != null && $user['password'] == $password) {
	$_SESSION['user'] = $user;
	redirect('index.php');
}
else {
	redirect('login.php');
}
