<?php
require_once 'common.php';

$role = getUserRole();
if ($role == ANONYMOUS_ROLE) redirect('/login.php');
if ($role == PATIENT_ROLE) redirect('/patient/tasks/today.php');
if ($role == DOCTOR_ROLE) redirect('/doctor/search.php');
