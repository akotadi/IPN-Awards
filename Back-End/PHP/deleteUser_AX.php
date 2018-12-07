<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$user     = $_POST["user"];
	$password = $_POST["password"];

	if (!empty($user) && !empty($password)) {
		$connection = connect();

		$user     = mysqli_real_escape_string($connection, $user);
		$password = mysqli_real_escape_string($connection, $password);

		$query = "SELECT * FROM user WHERE username = '$user'";

		$resultAwarded = $connection->query($query);
		if ($resultAwarded->num_rows > 0) {
			$extractUser = $resultAwarded->fetch_assoc();

			if (password_verify(base64_encode(hash('sha256', $password, true)), $extractUser["password"])) {

				$uQuery = "DELETE FROM user WHERE username = '$user'";

				if ($connection->query($uQuery)) {
					$response = array('valid' => true);
				} else {
					$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
				}
			} else {
				$response = array('valid' => false, 'message' => 'Contraseña incorrecta.');
			}
		} else {
			$response = array('valid' => false, 'message' => 'Usuario incorrecto.');
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