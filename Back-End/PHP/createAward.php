<?php
header('Content-Type: text/html; charset=utf-8');
require 'FPDF/fpdf.php';

include "./connection_DB.php";
include "./RESTResponse.php";

$rfc = $_GET["rfc"];

if (empty($rfc)) {
	session_destroy();
	echo $RESTResponse->FAIL;
} else {
	$connection = connect();

	$query = "SELECT a.name AS name, a.first_surname, a.second_surname, p.name AS procedency, ar.name AS area, d.name AS award, d1.name as maxAward FROM awarded a, procedency p, area ar, award d, award d1 WHERE a.idProcedency = p.idProcedency AND p.idArea = ar.idArea AND a.idAward = d.idAward AND d.Award_idAward = d1.idAward AND a.rfc = '" . $rfc . "'";

	$resultData    = mysqli_query($connection, $query);
	$numberResults = mysqli_num_rows($resultData);
	if ($numberResults > 0) {
		$extractData = $result->fetch_array();
		$stored      = $extractData['password'];

		$name       = $row["name"] . " " . $row["first_surname"] . " " . $row["second_surname"];
		$procedency = $row["procedency"];
		$area       = $row["area"];
		$award      = $row["award"];
		$maxAward   = $row["maxAward"];
	} else {
		$query = "SELECT a.name AS name, a.first_surname, a.second_surname, p.name AS procedency, ar.name AS area, d.name AS award FROM awarded a, procedency p, area ar, award d WHERE a.idProcedency = p.idProcedency AND p.idArea = ar.idArea AND a.idAward = d.idAward AND a.rfc = '" . $rfc . "'";
		if ($numberResults > 0) {
			$extractData = $result->fetch_array();
			$stored      = $extractData['password'];

			$name       = $row["name"] . " " . $row["first_surname"] . " " . $row["second_surname"];
			$procedency = $row["procedency"];
			$area       = $row["area"];
			$award      = $row["award"];
			$maxAward   = NULL;
		} else {
			echo $RESTResponse->FAIL;
		}
	}
}
mysqli_free_result($resultData);
close();

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
$procedencia = utf8_decode($procedencia);
$pdf->Text(149 - ($pdf->GetStringWidth($procedencia)) / 2, 128, $procedencia);

// Diploma
if ($maxDiploma != NULL) {
	$pdf->SetFontSize(20);
	$maxDiploma = utf8_decode($maxDiploma);
	$pdf->Text(149 - ($pdf->GetStringWidth($maxDiploma)) / 2, 155, $maxDiploma);
	$pdf->SetFontSize(16);
	$diploma = utf8_decode($diploma);
	$pdf->Text(149 - ($pdf->GetStringWidth($diploma)) / 2, 162, $diploma);
} else {
	$pdf->SetFontSize(18);
	$diploma = utf8_decode($diploma);
	$pdf->Text(149 - ($pdf->GetStringWidth($diploma)) / 2, 155, $diploma);
}

$pdf->Output();

// I: send the file inline to the browser. The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
// $file_contents = $pdf->Output("Award - ".$name.".pdf","I");

// D: send to the browser and force a file download with the name given by name.
// $file_contents = $pdf->Output("Award - " . $name . ".pdf", "D");

// F: save to a local file with the name given by name (may include a path).
// $file_contents = $pdf->Output("Award - ".$name.".pdf","F");

// S: return the document as a string. name is ignored.
// $file_contents = $pdf->Output("Award - ".$name.".pdf","S");
?>
