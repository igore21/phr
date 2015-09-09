<?php
require_once '../../header.php';

$patientId = $_SESSION['user']['id'];

$searchFollowingTasks = array(
	'patient_id' => $patientId,
	'from' => (new DateTime())->add(new DateInterval('P1D'))->format('y-m-d'),
	'limit' => 10,
);
$followingTasks = DB::getData($searchFollowingTasks);

$render['tableName'] = 'Sledeci zadaci';
$render['tasks'] = $followingTasks;

include 'taskTable.php';

require_once '../../footer.php';