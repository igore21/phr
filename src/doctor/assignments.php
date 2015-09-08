<?php
require_once '../header.php';
require_once '../common.php';
require_once '../DB.php';

$userId = $_SESSION['user']['id'];

$render = array();
$render['skipDoctor'] = true;
$render['tableName'] = 'Tabela aktivnih zadataka';
$render['allParameters'] = getTranslatedParameters();
$render['assignments'] = DB::getAssignments($userId, true, true);
include '../assignmentTable.php';

$render['tableName'] = 'Tabela neaktivnih zadataka';
$render['assignments'] = DB::getAssignments($userId, true, false);
include '../assignmentTable.php';

require '../footer.php';
