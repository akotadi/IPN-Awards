<?php
header('Content-Type: text/html; charset=utf-8');

require 'FPDF/personalizedPDF.php';

include "./connection_DB.php";
include "./RESTResponse.php";

$connection = connect();

setlocale(LC_TIME, "spanish");
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->addTitle(utf8_decode('DISTINCIONES AL MÉRITO POLITÉCNICO 2019'));

$sqlAward    = "SELECT name, speech FROM award";
$resultAward = $connection->query($sqlAward);
if ($resultAward->num_rows > 0) {
	while ($rowAward = $resultAward->fetch_assoc()) {
		$pdf->addAward(utf8_decode($rowAward['name']), utf8_decode($rowAward['speech']));
		$sqlArea    = "SELECT name FROM area";
		$resultArea = $connection->query($sqlArea);
		if ($resultArea->num_rows > 0) {
			while ($rowArea = $resultArea->fetch_assoc()) {
				$arrayArea[$rowAward['name'] . $rowArea['name']] = true;
				$sqlProcedency                                   = "SELECT p.name FROM procedency p, area ar WHERE p.idArea = ar.idArea AND ar.name = '" . $rowArea['name'] . "'";
				$resultProcedency                                = $connection->query($sqlProcedency);
				if ($resultProcedency->num_rows > 0) {
					while ($rowProcedency = $resultProcedency->fetch_assoc()) {
						$sqlAwarded    = "SELECT a.name, a.first_surname, a.second_surname FROM awarded a, procedency p, award d WHERE a.confirmed = 1 AND a.idProcedency = p.idProcedency AND a.idAward = d.idAward AND p.name = '" . $rowProcedency['name'] . "' AND d.name = '" . $rowAward['name'] . "'";
						$resultAwarded = $connection->query($sqlAwarded);
						if ($resultAwarded->num_rows > 0) {
							if (($arrayArea[$rowAward['name'] . $rowArea['name']])) {
								$pdf->addArea(utf8_decode($rowArea['name']));
							}
							$pdf->addProcedency(utf8_decode($rowProcedency['name']));
							while ($rowAwarded = $resultAwarded->fetch_assoc()) {
								$pdf->addName(utf8_decode($rowAwarded['name'] . ' ' . $rowAwarded['first_surname'] . ' ' . $rowAwarded['second_surname']));
							}
						}
					}
				}
			}
		}
	}
}

mysqli_free_result($resultAward);
mysqli_free_result($resultArea);
mysqli_free_result($resultProcedency);
mysqli_free_result($resultAwarded);

close();

$pdf->Output();
?>