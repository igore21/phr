<?php
require_once 'common.php';

$role = getUserRole();
if ($role == ANONYMOUS_ROLE) redirect('login.php');
echo 'des care';
