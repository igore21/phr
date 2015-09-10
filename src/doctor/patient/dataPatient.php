<?php
require_once '../../header.php';

$patientId = $_GET['user_id'];
$patient = DB::getUser(array('user_id' => $patientId));
if (empty($patient)) {
	redirect('/doctor/search.php');
}

include '../../common/searchData.php';

require_once '../../footer.php';