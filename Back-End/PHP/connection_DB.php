<?php
function connect() {
	$user           = "root";
	$pass           = "root";
	$server         = "localhost";
	$db_name        = "webelectivo";
	$testConnection = mysqli_connect($server, $user, $pass, $db_name);
	mysqli_query($testConnection, "SET NAMES 'utf8'");
	if (mysqli_connect_errno($testConnection)) {
		die("Problemas con la conexi&oacute;n al servidor MySQL: " . mysqli_connect_error());
	} else {
		mysqli_query($testConnection, "SET NAMES 'utf8'");
	}
	return $testConnection;
}

function close($connection) {
	return mysqli_close($connection);
}
?>