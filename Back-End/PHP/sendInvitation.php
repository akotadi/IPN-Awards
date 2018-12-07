<?php
header('Content-Type: text/html; charset=utf-8');

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

require './createInvitation.php';

require "./connection_DB.php";
include "./RESTResponse.php";

$response = array('valid' => false, 'message' => '');

if (isset($_POST) && !empty($_POST)) {

	$awardeds = $_POST["awardeds"];

	if (!empty($awardeds)) {

		$connection = connect();

		foreach ($awardeds as &$awarded) {
			$awarded = mysqli_real_escape_string($connection, $awarded);
		}

		$rfc   = join("','", $awardeds);
		$query = "SELECT * FROM awarded WHERE rfc IN ('$rfc')";

		$resultAwarded = $connection->query($query);
		if ($resultAwarded->num_rows > 0) {
			while ($extractAwarded = $resultAwarded->fetch_assoc()) {
				$pdfdoc = createInvitation($extractAwarded['rfc']);
				if (sendEmail($awardedAwarded['rfc'], $pdfdoc)) {
					$response = array('valid' => true);
				} else {
					$response = array('valid' => false, 'message' => 'Error enviando invitación.');
				}
			}
		} else {
			$response = array('valid' => false, 'message' => 'Correo no registrado.');
		}
		mysqli_free_result($resultAwarded);
		close($connection);
	} else {
		$response = array('valid' => false, 'message' => 'Debe enviar todos los parámetros.');
	}
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

function sendEmail($rfc, $pdfdoc) {
	if (empty($rfc) || empty($pdfdoc)) {
		return false;
	} else {
		$connection = connect();

		$query = "SELECT name, first_surname, second_surname, email, code FROM Awarded WHERE rfc = '" . $rfc . "'";

		$result        = mysqli_query($connection, $query);
		$numberResults = mysqli_num_rows($result);
		if ($numberResults == 1) {
			$extract          = $result->fetch_array();
			$code             = $extract['code'];
			$email            = $extract['email'];
			$name             = $extract['name'] . ' ' . $extract['first_surname'] . ' ' . $extract['second_surname'] . ' ';
			$confirmationLink = 'http://localhost:6789/ipn-awards/Back-End/PHP/confirmacion.php?rfc=' . $rfc . '&code=' . $code;
		} else {
			return false;
		}
	}

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
		$mail->setFrom('galardones.ipn@gmail.com', 'Galardones IPN');
		$mail->addAddress($email, $name);
		$mail->addAddress('manuel_7795@hotmail.com', 'BackUp'); // Add a recipient

		//Attachments
		$mail->addStringAttachment($pdfdoc, 'Invitacion.pdf'); // Add attachments

		//Content
		$mail->isHTML(true); // Set email format to HTML
		$mail->Subject = 'Invitación para la ceremonia del IPN';
		$mail->Body    = 'Buenas tardes, el Instituto Politécnico Nacional lo invita a la ceremonia, <a href="' . $confirmationLink . '">por favor clickea aquí para confirmar tu asistencia</a>. Felicidades y esperamos que nos honre con su amable presencia.';
		$mail->AltBody = 'Es necesario confirmar la asistencia, por favor visita ' . $confirmationLink . ' o revisa tu invitación para hacerlo.';

		$mail->send();
		return true;
	} catch (Exception $e) {
		return false;
	}
}

echo json_encode($response);

?>