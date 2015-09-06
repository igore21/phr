<?php
require_once 'constants.php';

function redirect($script, $params = null) {
	$command = 'Location: ' . $script;
	if (!empty($params)) {
		$command .= '?' . http_build_query($params);
	} 
	header($command);
	die();
}

function getUserRole () {
	$role = ANONYMOUS_ROLE;
	if(!isset($_SESSION)){
		session_start();
	}
	if (!empty($_SESSION['user'])) {
		$role = $_SESSION['user']['role'];
	}
	return $role;
}

