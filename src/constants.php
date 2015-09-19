<?php
define('ANONYMOUS_ROLE', -1);
define('DOCTOR_ROLE', 2);
define('PATIENT_ROLE', 1);

define('PERIOD_HOURS', 1);
define('PERIOD_DAYS', 2);
define('PERIOD_WEEKS', 3);

class DataState {
	const PENDING = 1;
	const DRAFT = 2;
	const COMPLETED = 3;
	const IGNORED = 4;
}