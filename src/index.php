<?php
require 'header.php';
require 'footer.php';
require_once 'DB.php';
require_once 'common.php';

$userId = $_SESSION['user']['id'];
$role = getUserRole();
if ($role == ANONYMOUS_ROLE) redirect('login.php');
echo 'des care';
