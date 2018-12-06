<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');
// debug_to_console($_POST);
if (isset($_POST) && !empty($_POST)) {
	session_start();
	sleep(2);

	$user     = $_POST["user"];
	$password = $_POST["password"];

	if (!empty($user) || !empty($password)) {
		$connection = connect();

		$user     = mysqli_real_escape_string($connection, $user);
		$password = mysqli_real_escape_string($connection, $password);

		$query = "SELECT * FROM user WHERE username = '$user'";

		$resultUser = $connection->query($query);
		if ($resultUser->num_rows > 0) {
			$extractUser = $resultUser->fetch_assoc();
			$stored      = $extractUser['password'];
			if (password_verify(base64_encode(hash('sha256', $_POST['password'], true)), $stored)) {
				$_SESSION['loggedin']    = true;
				$_SESSION['start_time']  = time();
				$_SESSION['expire_time'] = $_SESSION['start_time'] + (30 * 60);
				$_SESSION['user']        = $user;
				$_SESSION['type']        = $extractUser['idtype'];
				$response                = array('valid' => true);
			} else {
				session_destroy();
				$response = array('valid' => false, 'message' => 'Contraseña incorrecta.');
				exit;
			}
		} else {
			session_destroy();
			$response = array('valid' => false, 'message' => 'Usuario inexistente.');
		}
		mysqli_free_result($resultUser);
		close($connection);
	} else {
		session_destroy();
		$response = array('valid' => false, 'message' => 'Debe enviar todos los parámetros.');
	}
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

echo json_encode($response);

?>