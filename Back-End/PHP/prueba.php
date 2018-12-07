<?php
$response = array('valid' => false, 'message' => '');

if (isset($_GET)) {
	session_start();
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();

	$response = array('valid' => true);
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

echo json_encode($response);

?>