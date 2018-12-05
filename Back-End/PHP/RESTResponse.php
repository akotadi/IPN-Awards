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

$RESTResponse = new RESTResponse;
?>