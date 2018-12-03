<?php
include "./connection_DB.php";
include "./RESTResponse.php";

session_start();
sleep(2);

$user     = $_POST["user"];
$password = $_POST["password"];

if (empty($user) || empty($password)) {
	session_destroy();
	echo $RESTResponse->FAIL;
} else {
	$connection = connect();

	$query = "SELECT * FROM user WHERE username = '$user'";

	$resultUser    = mysqli_query($connection, $query);
	$numberResults = mysqli_num_rows($resultUser);
	if ($numberResults == 1) {
		$extractUser = $result->fetch_array();
		$stored      = $extractUser['password'];
		if (password_verify(base64_encode(hash('sha256', $_POST['password'], true)), $stored)) {
			$_SESSION['logged_in']   = true;
			$_SESSION['start_time']  = time();
			$_SESSION['expire_time'] = $_SESSION['start_time'] + (30 * 60);
			$_SESSION['user']        = $user;
			$_SESSION['type']        = $extractUser['idType'];
			echo $RESTResponse->OK;
		} else {
			session_destroy();
			echo $RESTResponse->FAIL;
			exit;
		}
	} else {
		session_destroy();
		echo $RESTResponse->FAIL;
	}
}
mysqli_free_result($resultUser);
close();
?>