<?php
require './connection_DB.php';
require './RESTResponse.php';

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$rfc = $_POST["rfc"];

	if (!empty($rfc)) {

		$connection = connect();

		$rfc = mysqli_real_escape_string($connection, $rfc);

		$query = "";

		if (isset($_POST["op1"]) && !empty($_POST["op1"])) {
			$option       = mysqli_real_escape_string($connection, $_POST["op1"]);
			$sql          = "SELECT idObservation FROM observation WHERE commentary LIKE '$option'";
			$resultOption = $connection->query($sql);
			if ($resultOption->num_rows > 0) {
				$extractOption = $resultOption->fetch_assoc();
				$observation   = $extractOption['idObservation'];
				$query         = "INSERT INTO awarded_has_observation (rfc, Observation_idObservation) VALUES ('$rfc', $observation)";
				$connection->query($query);
			}
		}
		if (isset($_POST["op2"]) && !empty($_POST["op2"])) {
			$option       = mysqli_real_escape_string($connection, $_POST["op2"]);
			$sql          = "SELECT idObservation FROM observation WHERE commentary LIKE '$option'";
			$resultOption = $connection->query($sql);
			if ($resultOption->num_rows > 0) {
				$extractOption = $resultOption->fetch_assoc();
				$observation   = $extractOption['idObservation'];
				$query         = "INSERT INTO awarded_has_observation (rfc, Observation_idObservation) VALUES ('$rfc', $observation)";
				$connection->query($query);
			}
		}
		if (isset($_POST["op3"]) && !empty($_POST["op3"])) {
			$option       = mysqli_real_escape_string($connection, $_POST["op3"]);
			$sql          = "SELECT idObservation FROM observation WHERE commentary LIKE '$option'";
			$resultOption = $connection->query($sql);
			if ($resultOption->num_rows > 0) {
				$extractOption = $resultOption->fetch_assoc();
				$observation   = $extractOption['idObservation'];
				$query         = "INSERT INTO awarded_has_observation (rfc, Observation_idObservation) VALUES ('$rfc', $observation)";
				$connection->query($query);
			}
		}
		if (isset($_POST["op4"]) && !empty($_POST["op4"])) {
			$option       = mysqli_real_escape_string($connection, $_POST["op4"]);
			$sql          = "SELECT idObservation FROM observation WHERE commentary LIKE '$option'";
			$resultOption = $connection->query($sql);
			if ($resultOption->num_rows > 0) {
				$extractOption = $resultOption->fetch_assoc();
				$observation   = $extractOption['idObservation'];
				$query         = "INSERT INTO awarded_has_observation (rfc, Observation_idObservation) VALUES ('$rfc', $observation)";
				$connection->query($query);
			}
		}
		if (isset($_POST["op5"]) && !empty($_POST["op5"])) {
			$option       = mysqli_real_escape_string($connection, $_POST["op5"]);
			$sql          = "SELECT idObservation FROM observation WHERE commentary LIKE '$option'";
			$resultOption = $connection->query($sql);
			if ($resultOption->num_rows > 0) {
				$extractOption = $resultOption->fetch_assoc();
				$observation   = $extractOption['idObservation'];
				$query         = "INSERT INTO awarded_has_observation (rfc, Observation_idObservation) VALUES ('$rfc', $observation)";
				$connection->query($query);
			}
		}
		if (isset($_POST["op6"]) && !empty($_POST["op6"])) {
			$option       = mysqli_real_escape_string($connection, $_POST["op6"]);
			$commentary   = mysqli_real_escape_string($connection, $_POST["otherInput"]);
			$sql          = "SELECT idObservation FROM observation WHERE commentary LIKE '$option'";
			$resultOption = $connection->query($sql);
			if ($resultOption->num_rows > 0) {
				$extractOption = $resultOption->fetch_assoc();
				$observation   = $extractOption['idObservation'];
				$query         = "INSERT INTO awarded_has_observation (rfc, Observation_idObservation, details) VALUES ('$rfc', $observation, '$commentary')";
				$connection->query($query);
			}
		}

		$response = array('valid' => true);
		close($connection);
	} else {
		$response = array('valid' => false, 'message' => 'Debe enviar todos los parámetros.');
	}
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

echo json_encode($response);

?>