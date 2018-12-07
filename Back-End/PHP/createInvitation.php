<?php
header('Content-Type: text/html; charset=utf-8');
require 'FPDF/personalizedInvitation.php';

function createInvitation($rfc, $conn) {
	if (empty($rfc) || empty($conn)) {
		return null;
	} else {

		$connection = $conn;

		$code = substr(md5(mt_rand()), 0, 15);

		$uQuery = "UPDATE awarded SET activation_code = '$code' WHERE rfc = '$rfc'";

		if ($connection->query($uQuery)) {
			$confirmationLink = 'http://localhost:6789/ipn-awards/Front-End/confirmacion.php?rfc=' . $rfc . '&code=' . $code;
		} else {
			return null;
		}
	}

	setlocale(LC_TIME, "spanish");
	$pdf = new PDF('P', 'mm', 'A4');
	$pdf->AddPage();

	$pdf->Image('invitacion.jpg', 0, 0, 210, 297, 'JPG');

	$pdf->Image('https://chart.googleapis.com/chart?chs=200x200&cht=qr&choe=ISO-8859-1&chl=' . urlencode($rfc), 105 - (33 / 2), 230, 33, 33, 'PNG');

	$pdf->SetFont('Arial', 'U', 15);
	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetXY(105 - ($pdf->GetStringWidth('CONFIRMAR ASISTENCIA') / 2), 271);
	$pdf->Write(5, 'CONFIRMAR ASISTENCIA', $confirmationLink);

	return $pdf->Output('', 'S');
}

?>