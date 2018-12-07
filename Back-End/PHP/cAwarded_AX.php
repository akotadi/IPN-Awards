<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$rfc           = $_POST["rfc"];
	$name          = $_POST["name"];
	$firstSurname  = $_POST["firstSurname"];
	$secondSurname = $_POST["secondSurname"];
	$email         = $_POST["email"];
	$award         = $_POST["award"];
	$procedency    = $_POST["procedency"];

	if (!empty($rfc) && !empty($name) && !empty($email) && !empty($award) && !empty($procedency)) {
		$connection = connect();

		$rfc  = mysqli_real_escape_string($connection, $rfc);
		$name = mysqli_real_escape_string($connection, $name);
		if (!empty($fSurname)) {
			$fSurname = mysqli_real_escape_string($connection, $fSurname);
		}
		if (!empty($sSurname)) {
			$sSurname = mysqli_real_escape_string($connection, $sSurname);
		}
		$email      = mysqli_real_escape_string($connection, $email);
		$award      = mysqli_real_escape_string($connection, $award);
		$procedency = mysqli_real_escape_string($connection, $procedency);

		$uQuery = "INSERT INTO awarded VALUES ('$rfc', '$name','$firstSurname', '$secondSurname', '$email', null, null, 0, 0, $award, $procedency)";

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