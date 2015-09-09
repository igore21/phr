<?php
require_once '../header.php';
require_once '../common.php';
require_once '../DB.php';

$patientId = $_SESSION['user']['id'];

$render = array();
$render['skipPatient'] = true;
$render['skipDetailsLink'] = true;
$render['tableName'] = 'Tabela aktivnih zadataka';
$render['allParameters'] = getTranslatedParameters();
$render['assignments'] = DB::getAssignments($patientId, false, true);
include '../assignmentTable.php';

$render['tableName'] = 'Tabela neaktivnih zadataka';
$render['assignments'] = DB::getAssignments($patientId, false, false);
include '../assignmentTable.php';

require '../footer.php';