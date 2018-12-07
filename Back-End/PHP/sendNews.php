<?php
header('Content-Type: text/html; charset=utf-8');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require "./connection_DB.php";
include "./RESTResponse.php";

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$awardeds = $_POST["rfclist"];
	$text = $_POST["text"];
	$subject = $_POST["subject"];

	if (!empty($awardeds) && !empty($text) && !empty($subject)) {

		$connection = connect();

		foreach ($awardeds as &$awarded) {
			$awarded = mysqli_real_escape_string($connection, $awarded);
		}
		$text = mysqli_real_escape_string($connection, $text);
		$subject = mysqli_real_escape_string($connection, $subject);

		$rfc   = join("','", $awardeds);
		$query = "SELECT * FROM awarded WHERE rfc IN ('$rfc')";

		$resultAwarded = $connection->query($query);
		if ($resultAwarded->num_rows > 0) {
			$mail = new PHPMailer(true); // Passing `true` enables exceptions
			try {
				//Server settings
				$mail->CharSet   = 'UTF-8';
				$mail->SMTPDebug = 0; // Enable verbose debug output
				$mail->isSMTP(); // Set mailer to use SMTP
				$mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
				$mail->SMTPAuth   = true; // Enable SMTP authentication
				$mail->Username   = 'galardones.ipn@gmail.com'; // SMTP username
				$mail->Password   = 'drejnfaeduqydwrp'; // SMTP password
				$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
				$mail->Port       = 587; // TCP port to connect to

				//Recipients
				$mail->setFrom('galardones.ipn@gmail.com', 'Galardones IPN');z
				while ($extractAwarded = $resultAwarded->fetch_assoc()) {
					$name = $extractAwarded['name'] . ' ' . $extractAwarded['first_surname'] . ' ' . $extractAwarded['second_surname'];
					$mail->addAddress($extractAwarded['email'], $name);
				}
				
				$mail->addAddress('manuel_7795@hotmail.com', 'BackUp'); // Add a recipient

				//Content
				$mail->isHTML(true); // Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = $text;

				$mail->send();
				$response = array('valid' => true);
			} catch (Exception $e) {
				$response = array('valid' => false, 'message' => 'Error enviando aviso.');
			}
		} else {
			$response = array('valid' => false, 'message' => 'Galardonados no registrados.');
		}
		mysqli_free_result($resultAwarded);
		close($connection);
	} else {
		$response = array('valid' => false, 'message' => 'Debe enviar todos los parámetros.');
	}
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

echo json_encode($response);

?>