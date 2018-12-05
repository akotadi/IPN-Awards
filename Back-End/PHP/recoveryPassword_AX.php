<?php
require './connection_DB.php';
require './RESTResponse.php';
require './PHPMailer/Exception.php';
require './PHPMailer/PHPMailer.php';
require './PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

if (isset($_POST) & !empty($_POST)) {
	$connection = connect();

	$email = $_POST['email'];

	if (empty($email)) {
		echo $RESTResponse::FAIL;
	} else {
		$email = mysqli_real_escape_string($connection, $email);

		$query = "SELECT * FROM user WHERE email = '$email'";

		$resultUser = $connection->query($query);
		if ($resultUser->num_rows > 0) {
			$extractUser = $resultUser->fetch_assoc();
			$password    = rand(1000, 99999999);

			$options = [
				'cost' => 10,
			];
			$stored = password_hash(
				base64_encode(
					hash('sha256', $password, true)
				),
				PASSWORD_BCRYPT, $options
			);

			$user = $extractUser['username'];

			$uQuery = "UPDATE user SET password = '$stored' WHERE username = '$user'";

			if ($connection->query($uQuery)) {

				$mail = new PHPMailer(true); // Passing `true` enables exceptions
				try {
					//Server settings
					$mail->CharSet   = 'UTF-8';
					$mail->SMTPDebug = 1; // Enable verbose debug output
					$mail->isSMTP(); // Set mailer to use SMTP
					$mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
					$mail->SMTPAuth   = true; // Enable SMTP authentication
					$mail->Username   = 'galardones.ipn@gmail.com'; // SMTP username
					$mail->Password   = 'drejnfaeduqydwrp'; // SMTP password
					$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
					$mail->Port       = 587; // TCP port to connect to

					//Recipients
					$mail->setFrom('galardones.ipn@gmail.com', 'Galardones IPN');
					$mail->addAddress($email, $user);
					$mail->addAddress('manuel_7795@hotmail.com', 'BackUp'); // Add a recipient

					//Content
					$mail->isHTML(true); // Set email format to HTML
					$mail->Subject = 'Tu contraseña de recuperación';
					$mail->Body    = 'Hola, como lo has solicitado, tu contraseña se ha recuperado, ingresa con ' . $password . ' para continuar en el sitio.';
					$mail->AltBody = 'Hola, como lo has solicitado, tu contraseña se ha recuperado, ingresa con ' . $password . ' para continuar en el sitio.';

					$mail->send();
					echo $RESTResponse::OK;
				} catch (Exception $e) {
					echo $RESTResponse::FAIL;
				}
			} else {
				echo $RESTResponse::FAIL;
			}
		} else {
			echo $RESTResponse::FAIL;
		}
	}
} else {
	echo $RESTResponse::FAIL;
}
mysqli_free_result($resultUser);
close($connection);
?>