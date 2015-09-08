<?php
require_once '../../common.php';
require_once '../../DB.php';
require '../../header.php';

if (empty($_GET['user_id']) || empty($_GET['assignment_id'])) {
	redirect('/doctor/search.php');
}

$assignmentId = $_GET['assignment_id'];
$assignment = DB::getAssignment($assignmentId);

$tableTitle = "Detalji zadatka";
$buttonName = "Izmeni Zadatak";

include 'createEditAssignmentForm.php';

require '../../footer.php';