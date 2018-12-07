<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$user       = $_POST["user"];
	$password   = $_POST["password"];
	$email      = $_POST["email"];
	$procedency = $_POST["procedency"];

	if (!empty($user) && !empty($password) && !empty($email) && !empty($procedency)) {
		$connection = connect();

		$user       = mysqli_real_escape_string($connection, $user);
		$password   = mysqli_real_escape_string($connection, $password);
		$email      = mysqli_real_escape_string($connection, $email);
		$procedency = mysqli_real_escape_string($connection, $procedency);

		$options = [
			'cost' => 10,
		];

		$stored = password_hash(
			base64_encode(
				hash('sha256', $password, true)
			),
			PASSWORD_BCRYPT, $options
		);

		$uQuery = "INSERT INTO user (username, email, password, activation_code, verified, idtype) VALUES ('$user', '$email','$stored', null, 0, $procedency)";

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