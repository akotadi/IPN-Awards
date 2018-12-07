<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$assistant = $_POST["rfc"];

	if (!empty($assistant)) {
		$connection = connect();

		$assistant = mysqli_real_escape_string($connection, $assistant);

		$uQuery = "UPDATE awarded SET is_present = 0 WHERE rfc = '$assistant'";

		if ($connection->query($uQuery)) {
			$response = array('valid' => true);
		} else {
			$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
		}
		close($connection);
	} else {
		$response = array('valid' => false, 'message' => 'Debe enviar todos los parámetros.');
	}
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

echo json_encode($response);

?>