<?php
require './connection_DB.php';
require './RESTResponse.php';

if (isset($_POST) & !empty($_POST)) {

	$assistant = $_POST["rfc"];

	if (!empty($assistant)) {
		$connection = connect();

		$assistant = mysqli_real_escape_string($connection, $assistant);

		$uQuery = "UPDATE awarded SET is_present = 1 WHERE rfc = '$assistant'";

		if ($connection->query($uQuery)) {
			echo $RESTResponse::OK;
		} else {
			echo $RESTResponse::FAIL;
		}
		close($connection);
	} else {
		echo $RESTResponse::FAIL;
	}
} else {
	echo $RESTResponse::FAIL;
}
?>