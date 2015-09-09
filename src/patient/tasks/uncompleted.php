<?php
require_once '../../header.php';

$patientId = $_SESSION['user']['id'];

$searchUncopletedTasks = array(
	'patient_id' => $patientId,
	'to' => (new DateTime())->format('y-m-d'),
	'completed' => 'false',
);
$uncompletedTasks = DB::getData($searchUncopletedTasks);

$render['tableName'] = 'Nepopunjeni zadaci';
$render['tasks'] = $uncompletedTasks;
$render['showValuesAndActions'] = true;
$render['showIgnoreButton'] = true;

include 'taskTable.php';

require_once '../../footer.php';