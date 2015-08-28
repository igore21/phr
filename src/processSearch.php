<?php
require_once 'DB.php';
require_once 'common.php';


if (empty($_GET['id']) && empty($_GET['email']) && empty($_GET['first_name']) && empty($_GET['last_name'])) {
	redirect('search.php');
}

$id = $_GET['id'];
$email = $_GET['email'];
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];

var_dump($_GET);

//$user = DB::getUserByMail($mail);


// if ($user != null && $user['password'] == $password) {
// 	$_SESSION['user'] = $user;
// 	$r = getUserRole();
// 	var_dump($r);
// 	if ($r == 1) redirect('index.php');
// 	if ($r == 2) redirect('index.php');
// 	var_dump($r);
// }
// else {
// 	redirect('login.php');
// }


?>