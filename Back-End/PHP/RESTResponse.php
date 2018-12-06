<?php
class RESTResponse {
	private $code;
	private $message;
	private $payload;
	const OK     = 200;
	const FAIL   = 500;
	const DBFAIL = 501;

	// public function __construct($code, $message, $payload) {
	// 	$this->code    = $code;
	// 	$this->message = $message;
	// 	$this->payload = $payload;
	// }

}

function debug_to_console($data) {
	$output = $data;
	if (is_array($output)) {
		$output = implode(',', $output);
	}

	echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>