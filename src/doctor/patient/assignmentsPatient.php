<?php
require '../../header.php';
require_once '../../common.php';
require_once '../../DB.php';

$patientId = $_GET['user_id'];
$patient = DB::getUser(array('user_id' => $patientId));
if (empty($patient)) {
	redirect('/doctor/search.php');
}
?>
<span class="assignment_patient">

<?php
$render = array();
$render['skipPatient'] = true;
$render['tableName'] = 'Tabela aktivnih zadataka';
$render['allParameters'] = getTranslatedParameters();
$render['assignments'] = DB::getAssignments($patientId, false, true);
include '../../assignmentTable.php';

$render['tableName'] = 'Tabela neaktivnih zadataka';
$render['assignments'] = DB::getAssignments($patientId, false, false);
include '../../assignmentTable.php';
?>

</span>

<?php
require '../../footer.php';
