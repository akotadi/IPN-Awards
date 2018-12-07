<?php
header('Content-Type: text/html; charset=utf-8');
require 'FPDF/fpdf.php';

require "./connection_DB.php";
include "./RESTResponse.php";

if (isset($_GET) && !empty($_GET)) {

	$rfc = $_GET["rfc"];

	if (!empty($rfc)) {
		$connection = connect();

		$rfc = mysqli_real_escape_string($connection, $rfc);

		$query = "SELECT a.name AS name, a.first_surname, a.second_surname, p.name AS procedency, ar.name AS area, d.name AS award, d1.name as maxAward FROM awarded a, procedency p, area ar, award d, award d1 WHERE a.idProcedency = p.idProcedency AND p.idArea = ar.idArea AND a.idAward = d.idAward AND d.Award_idAward = d1.idAward AND a.rfc = '" . $rfc . "'";

		$resultAwarded = $connection->query($query);
		if ($resultAwarded->num_rows > 0) {
			$extractAwarded = $resultAwarded->fetch_assoc();
			$name           = $extractAwarded['name'] . ' ' . $extractAwarded['first_surname'] . ' ' . $extractAwarded['second_surname'];
			$procedency     = $extractAwarded['procedency'];
			$area           = $extractAwarded['area'];
			$award          = $extractAwarded['award'];
			$maxAward       = $extractAwarded['maxAward'];
		} else {
			$query = "SELECT a.name AS name, a.first_surname, a.second_surname, p.name AS procedency, ar.name AS area, d.name AS award FROM awarded a, procedency p, area ar, award d WHERE a.idProcedency = p.idProcedency AND p.idArea = ar.idArea AND a.idAward = d.idAward AND a.rfc = '" . $rfc . "'";

			$resultAwarded = $connection->query($query);
			if ($resultAwarded->num_rows > 0) {
				$extractAwarded = $resultAwarded->fetch_assoc();
				$name           = $extractAwarded['name'] . ' ' . $extractAwarded['first_surname'] . ' ' . $extractAwarded['second_surname'];
				$procedency     = $extractAwarded['procedency'];
				$area           = $extractAwarded['area'];
				$award          = $extractAwarded['award'];
				$maxAward       = NULL;
			} else {
				$response = array('valid' => false, 'message' => 'Galardonado inexistente.');
			}
		}
		mysqli_free_result($resultAwarded);
		close($connection);
	} else {
		session_destroy();
		$response = array('valid' => false, 'message' => 'Debe enviar todos los parámetros.');
	}
} else {
	$response = array('valid' => false, 'message' => 'Hubo un problema, por favor intente de nuevo.');
}

if (!empty($name) && !empty($procedency) && !empty($area) && !empty($award)) {
	$pdf = new FPDF('L', 'mm', 'A4');
	$pdf->AddPage();
	$pdf->SetFont('Arial', '', 11);
	$pdf->SetTextColor(101, 101, 101);

	$pdf->Image('reconocimiento.png', 0, 0, 298, 0, 'PNG');

	$months = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$day    = date("d");
	$month  = $months[date("n")];
	$year   = date("Y");
	$pdf->Text(48.7, 20.5, $day);
	$pdf->Text(69 - ($pdf->GetStringWidth($month)) / 2, 20.5, $month);
	$pdf->Text(86, 20.5, $year);

	$pdf->SetTextColor(51, 51, 51);

	// Name
	$pdf->SetFontSize(25);
	$name = utf8_decode($name);
	$pdf->Text(149 - ($pdf->GetStringWidth($name)) / 2, 96, $name);

	// Level
	$pdf->SetFontSize(18);
	$area = utf8_decode($area);
	$pdf->Text(149 - ($pdf->GetStringWidth($area)) / 2, 122, $area);

	// School
	$pdf->SetFontSize(13);
	$procedency = utf8_decode($procedency);
	$pdf->Text(149 - ($pdf->GetStringWidth($procedency)) / 2, 128, $procedency);

	// Award
	if ($maxAward != NULL) {
		$pdf->SetFontSize(20);
		$maxAward = utf8_decode($maxAward);
		$pdf->Text(149 - ($pdf->GetStringWidth($maxAward)) / 2, 155, $maxAward);
		$pdf->SetFontSize(16);
		$award = utf8_decode($award);
		$pdf->Text(149 - ($pdf->GetStringWidth($award)) / 2, 162, $award);
	} else {
		$pdf->SetFontSize(18);
		$award = utf8_decode($award);
		$pdf->Text(149 - ($pdf->GetStringWidth($award)) / 2, 155, $award);
	}

	$pdf->Output("Award - " . $name . ".pdf", "D");
}

// I: send the file inline to the browser. The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
// $file_contents = $pdf->Output("Diploma - ".$name.".pdf","I");

// D: send to the browser and force a file download with the name given by name.
// $file_contents = $pdf->Output("Diploma - " . $name . ".pdf", "D");

// F: save to a local file with the name given by name (may include a path).
// $file_contents = $pdf->Output("Diploma - ".$name.".pdf","F");

// S: return the document as a string. name is ignored.
// $file_contents = $pdf->Output("Diploma - ".$name.".pdf","S");
?>
