<?php
require_once 'DB.php';
require_once 'common.php';

$allParameters = DB::getAllParameters();
DB::cleanEverything();

$temp = array(
	'parameter_id' => 4, 'execute_after' => 12, 'time_unit' => 1,
	'comment' => 'Meriti temperaturu ujutru i uvece.',
);
$frevex = array(
	'parameter_id' => 1, 'execute_after' => 8, 'time_unit' => 1,
	'comment' => 'Piti ferveks na 8 sati.',
);
$mucnina = array(
	'parameter_id' => 11, 'execute_after' => 8, 'time_unit' => 1,
	'comment' => 'Upisati osecaj mucnine posle svakog obroka',
);


$ass = array(
	'patient_id' => 3, 'doctor_id' => 1,
	'name' => 'Cesta malaksalost', 'description' => 'Pacijent se zali na cestu malaksalost',
	'start_time' => (new DateTime())->sub(new DateInterval('P1D'))->format('y-m-d'),
	'end_time' => (new DateTime())->add(new DateInterval('P3D'))->format('y-m-d'),
	'params' => array($temp),
);
$ass['assignment_id'] = DB::createAssignment($ass);
DB::insertAssignmentData(getScheduledTasks($ass, $allParameters));

$ass = array(
	'patient_id' => 3, 'doctor_id' => 1,
	'name' => 'Grip', 'description' => 'Curenje nosa, kasalj - uzimati antibiotike',
	'start_time' => (new DateTime())->sub(new DateInterval('P9D'))->format('y-m-d'),
	'end_time' => (new DateTime())->sub(new DateInterval('P5D'))->format('y-m-d'),
	'params' => array($temp, $frevex),
);
$ass['assignment_id'] = DB::createAssignment($ass);
DB::insertAssignmentData(getScheduledTasks($ass, $allParameters));

$ass = array(
	'patient_id' => 3, 'doctor_id' => 2,
	'name' => 'Stomacni virus', 'description' => 'Uobicajeni simptomi stomacnog virusa',
	'start_time' => (new DateTime())->sub(new DateInterval('P20D'))->format('y-m-d'),
	'end_time' => (new DateTime())->sub(new DateInterval('P15D'))->format('y-m-d'),
	'params' => array($mucnina),
);
$ass['assignment_id'] = DB::createAssignment($ass);
DB::insertAssignmentData(getScheduledTasks($ass, $allParameters));

echo 'ok';