<?php

function redirect($script, $params = null) {
	$command = 'Location: ' . $script;
	if (!empty($params)) {
		$command .= '?' . http_build_query($params);
	} 
	header($command);
	die();
}

?>
