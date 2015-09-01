<?php
require_once 'common.php';

if(!isset($_SESSION)){
	session_start();
}
session_unset();
redirect('/login.php');

