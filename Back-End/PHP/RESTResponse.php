<?php
class RESTResponse {
	private $code;
	private $message;
	private $payload;
	public const OK     = 200;
	public const FAIL   = 500;
	public const DBFAIL = 501;

	public function __construct($code, $message, $payload) {
		$this->code    = $code;
		$this->message = $message;
		$this->payload = $payload;
	}

}

$RESTResponse = new RESTResponse;
?>