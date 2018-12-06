<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$rfc = $_POST["dataRFC"];

	if (!empty($rfc)) {
		$connection = connect();

		$rfc = mysqli_real_escape_string($connection, $rfc);

		$query = "SELECT * FROM awarded WHERE rfc = '$rfc'";

		$resultAwarded = $connection->query($query);
		if ($resultAwarded->num_rows > 0) {

			$response = array('valid' => true);
		} else {
			$response = array('valid' => false, 'message' => 'RFC no registrado.');
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