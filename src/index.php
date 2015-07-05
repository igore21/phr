<?php
require_once 'DB.php';

echo 'Result : ';
$res = DB::getRes();
var_dump($res);