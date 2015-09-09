<?php
require_once '../../header.php';

$patientId = $_SESSION['user']['id'];

$searchTodaysTasks = array(
	'patient_id' => $patientId,
	'from' => (new DateTime())->format('y-m-d'),
	'to' => (new DateTime())->add(new DateInterval('P1D'))->format('y-m-d'),
	'completed' => 'false',
);
$tasksForToday = DB::getData($searchTodaysTasks);
// var_dump($tasksForToday);

$render['tableName'] = 'Dananji zadaci';
$render['tasks'] = $tasksForToday;
$render['showValuesAndActions'] = true;

include 'taskTable.php';

require_once '../../footer.php';