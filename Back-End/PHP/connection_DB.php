<?php
function connect() {
	$user           = "root";
	$pass           = "root";
	$server         = "localhost";
	$db_name        = "ipn-awards";
	$testConnection = new mysqli($server, $user, $pass, $db_name);
	if ($testConnection->connect_error) {
		die("Problemas con la conexi&oacute;n al servidor MySQL: " . $testConnection->connect_error);
	}
	if (!$testConnection->set_charset("utf8")) {
		die("Error cambiando la configuración utf8: " . $testConnection->error);
	}
	return $testConnection;
}

function close($connection) {
	return $connection->close();
}
?>