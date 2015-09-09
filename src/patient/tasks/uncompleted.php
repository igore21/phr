<?php
require_once '../../header.php';

$patientId = $_SESSION['user']['id'];

$searchUncopletedTasks = array(
	'patient_id' => $patientId,
	'to' => (new DateTime())->format('y-m-d'),
	'completed' => 'false',
);
$uncompletedTasks = DB::getData($searchUncopletedTasks);
// var_dump($uncompletedTasks);

$render['tableName'] = 'Nepopunjeni zadaci';
$render['tasks'] = $uncompletedTasks;

include 'taskTable.php';

require_once '../../footer.php';