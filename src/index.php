<?php
require_once 'common.php';

$role = getUserRole();
if ($role == ANONYMOUS_ROLE) redirect('/login.php');
if ($role == PACIENT_ROLE) redirect('/patient/home.php');
if ($role == DOCTOR_ROLE) redirect('/doctor/search.php');
