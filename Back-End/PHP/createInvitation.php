<?php
header('Content-Type: text/html; charset=utf-8');
require 'FPDF/personalizedInvitation.php';

function createInvitation($rfc) {
	if (empty($rfc)) {
		return null;
	} else {

		$code = md5(mt_rand());

		$query = "UPDATE Awarded SET activation_code = '" . $code . "' WHERE rfc = '" . $rfc . "'";

		if (!mysqli_query($connection, $query)) {
			return null;
		} else {
			$confirmationLink = 'http://localhost:6789/ipn-awards/Back-End/PHP/confirmAssistance.php?rfc=' . $rfc . '&code=' . $code;
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