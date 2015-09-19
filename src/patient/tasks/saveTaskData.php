<?php
require_once '../../DB.php';
require_once '../../common.php';
require_once '../../constants.php';

$output = array();
try {
	session_start();
	$user = $_SESSION['user'];
	
	if (empty($_POST['data'])) {
		throw new Exception('Greska u prosledjenim parametrima.');
	}

	$output = array();
	foreach ($_POST['data'] as $dataRow) {
		if (empty($dataRow['value']) && $dataRow['state'] == DataState::COMPLETED) {
			$dataRow['state'] = DataState::IGNORED;
		}
		$output[$dataRow['id']] = DB::updateTask($dataRow);
	}
} catch (Exception $e) {
	$output['error'] = $e->getMessage();
}

echo json_encode($output);