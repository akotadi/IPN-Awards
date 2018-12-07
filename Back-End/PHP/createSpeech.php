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

$sqlaward    = "SELECT name, speech FROM award";
$resultaward = $connection->query($sqlaward);
if ($resultaward->num_rows > 0) {
	while ($rowaward = $resultaward->fetch_assoc()) {
		$pdf->addaward(utf8_decode($rowaward['name']), utf8_decode($rowaward['speech']));
		$sqlarea    = "SELECT name FROM area";
		$resultarea = $connection->query($sqlarea);
		if ($resultarea->num_rows > 0) {
			while ($rowarea = $resultarea->fetch_assoc()) {
				$arrayarea[$rowaward['name'] . $rowarea['name']] = true;
				$sqlProcedency                                   = "SELECT p.name FROM procedency p, area ar WHERE p.idarea = ar.idarea AND ar.name = '" . $rowarea['name'] . "'";
				$resultProcedency                                = $connection->query($sqlProcedency);
				if ($resultProcedency->num_rows > 0) {
					while ($rowProcedency = $resultProcedency->fetch_assoc()) {
						$sqlawarded    = "SELECT a.name, a.first_surname, a.second_surname FROM awarded a, procedency p, award d WHERE a.confirmed = 1 AND a.idProcedency = p.idProcedency AND a.idaward = d.idaward AND p.name = '" . $rowProcedency['name'] . "' AND d.name = '" . $rowaward['name'] . "'";
						$resultawarded = $connection->query($sqlawarded);
						if ($resultawarded->num_rows > 0) {
							if (($arrayarea[$rowaward['name'] . $rowarea['name']])) {
								$pdf->addarea(utf8_decode($rowarea['name']));
							}
							$pdf->addProcedency(utf8_decode($rowProcedency['name']));
							while ($rowawarded = $resultawarded->fetch_assoc()) {
								$pdf->addName(utf8_decode($rowawarded['name'] . ' ' . $rowawarded['first_surname'] . ' ' . $rowawarded['second_surname']));
							}
						}
					}
				}
			}
		}
	}
}

mysqli_free_result($resultaward);
mysqli_free_result($resultarea);
mysqli_free_result($resultProcedency);
mysqli_free_result($resultawarded);

close();

$pdf->Output();
?>