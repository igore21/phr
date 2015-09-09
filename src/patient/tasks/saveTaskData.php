<?php
require_once '../../DB.php';
require_once '../../common.php';
require_once '../../constants.php';

$output = array();
try {
	session_start();
	$user = $_SESSION['user'];
	
	if (empty($_POST['id'])) {
		throw new Exception('Greska u prosledjenim parametrima.');
	}
	$dataRow = array(
		'id' => $_POST['id'],
		'ignored' => (isset($_POST['ignored']) && $_POST['ignored'] == true),
	);

	if (!$dataRow['ignored']) {
		if (empty($_POST['data_type']) || empty($_POST['value'])) {
			throw new Exception('Greska u prosledjenim parametrima.');
		}
		$dataRow['data_type'] = $_POST['data_type'];
		$dataRow['value'] = $_POST['value'];
		DB::completeTaskData($dataRow);
	} else {
		DB::ignoreTaskData($dataRow);
	}
	
} catch (Exception $e) {
	$output['error'] = $e->getMessage();
}

echo json_encode($output);