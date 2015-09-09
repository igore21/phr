<?php
require_once 'constants.php';
require_once 'DB.php';

function redirect($script, $params = null) {
	$command = 'Location: ' . $script;
	if (!empty($params)) {
		$command .= '?' . http_build_query($params);
	} 
	header($command);
	die();
}

function getUserRole () {
	$role = ANONYMOUS_ROLE;
	if(!isset($_SESSION)){
		session_start();
	}
	if (!empty($_SESSION['user'])) {
		$role = $_SESSION['user']['role'];
	}
	return $role;
}

function getTranslatedParameters() {
	$allParameters = DB::getAllParameters();
	foreach ($allParameters as $id => $param) {
		if (isset($TANSLATED_PARAMETERS_RS[$param['name']])) {
			$allParameters[$id]['name'] = $TANSLATED_PARAMETERS_RS[$param['name']];
		}
	}
	
	return $allParameters;
}

function getScheduledTasks($assignment, $allParameters, $isNewAssignment = true) {
	$currentTime = new DateTime();
	$scheduledData = array();
	foreach ($assignment['params'] as $param) {
		$dataRow = array(
			'assignment_id' => $assignment['assignment_id'],
			'patient_id' => $assignment['patient_id'],
			'parameter_id' => $param['parameter_id'],
			'data_type' => $allParameters[$param['parameter_id']]['data_type'],
		);
		
		$timeDiffHours = 0;
		if ($param['time_unit'] == PERIOD_HOURS) $timeDiffHours = $param['execute_after'];
		if ($param['time_unit'] == PERIOD_DAYS) $timeDiffHours = $param['execute_after'] * 24;
		if ($param['time_unit'] == PERIOD_WEEKS) $timeDiffHours = $param['execute_after'] * 24*7;
		if ($timeDiffHours <= 0) {
			return null;
		}
		
		$scheduledTime = new DateTime($assignment['start_time']);
		if (!$isNewAssignment && $scheduledTime < $currentTime) {
			$scheduledTime = $currentTime;
		}
		$endTime = new DateTime($assignment['end_time']);
		$timeInterval = new DateInterval('P0DT' . $timeDiffHours . 'H');
		
		while ($scheduledTime < $endTime) {
			$dataRow['scheduled_time'] = $scheduledTime->format('Y-m-d H:i:s');
			$scheduledTime->add($timeInterval);
			$scheduledData[] = $dataRow;
		}
	}
	return $scheduledData;
}