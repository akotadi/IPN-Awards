<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$user = $_POST["user"];

	if (!empty($user)) {
		$connection = connect();

		$user = mysqli_real_escape_string($connection, $user);

		$uQuery = "DELETE FROM user WHERE username = '$user'";

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