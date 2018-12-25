<?php
require './connection_DB.php';
require './RESTResponse.php';

$connection = connect();

$value = mt_rand(1, 544);

$query = "SELECT * FROM awarded LIMIT $value OFFSET " . (mt_rand(1, 544));

$resultAwarded = $connection->query($query);
if ($resultAwarded->num_rows > 0) {
	while ($extractAwarded = $resultAwarded->fetch_assoc()) {
		$uQuery = "UPDATE awarded SET confirmed = 1 WHERE rfc = '" . $extractAwarded["rfc"] . "'";

		if ($connection->query($uQuery)) {
			$response = array('valid' => true);
		} else {
			$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
		}
	}
}

// while($value--){
// 	$uQuery = "UPDATE awarded SET is_present = 0 WHERE rfc = '$assistant'";

// 	if ($connection->query($uQuery)) {
// 		$response = array('valid' => true);
// 	} else {
// 		$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
// 	}
// }

?>