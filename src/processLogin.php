<?php
require_once 'DB.php';
require_once 'common.php';

if (empty($_POST['usermail']) || empty($_POST['password'])) {
	redirect('login.php');
}

$mail = $_POST['usermail'];
$password = $_POST['password'];

$user = DB::getUserByMail($mail);
//var_dump($user);

session_start();

if ($user != null && $user['password'] == $password) {
	$_SESSION['user'] = $user;
	//$niz = array();
	$niz = $_SESSION;
	//echo $_SESSION['SID'];
	//$session_id = $_COOKIE[$_SESSION['user']];
	$broj = count($_SESSION['user']);
	echo $broj;
	echo ($_SESSION['user'][$broj-$broj]);
	//echo $session_id;
	//$upit = query(select );
	//echo $niz['usermail']['password'];
    //redirect('index.php');
}
else {
	echo 'ne';
	redirect('login.php');
}
