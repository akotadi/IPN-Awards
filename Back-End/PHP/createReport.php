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
$pdf->addSubTitle(utf8_decode('Reporte y estadísticas'));

// Read text file
$txt = file_get_contents("introReport.txt");
// Times 12
$pdf->SetFont('Arial', '', 12);
// Output justified text
$pdf->MultiCell(0, 5, utf8_decode($txt));
// Line break
$pdf->Ln();

$dataAssistance = array();

$sqlAssistance    = "SELECT count(*) as total FROM awarded";
$resultAssistance = $connection->query($sqlAssistance);
if ($resultAssistance->num_rows > 0) {
	while ($rowAssistance = $resultAssistance->fetch_assoc()) {
		$nAssistance = $rowAssistance['total'];

		$sqlPresent    = "SELECT count(*) as total FROM awarded WHERE is_present = 1";
		$resultPresent = $connection->query($sqlPresent);
		if ($resultPresent->num_rows > 0) {
			while ($rowPresent = $resultPresent->fetch_assoc()) {
				if ($rowPresent['total'] != 0) {
					$dataAssistance[utf8_decode('Asistentes')] = $rowPresent['total'];
				}
			}
		}

		$sqlAbsent    = "SELECT count(*) as total FROM awarded WHERE is_present = 0";
		$resultAbsent = $connection->query($sqlAbsent);
		if ($resultAbsent->num_rows > 0) {
			while ($rowAbsent = $resultAbsent->fetch_assoc()) {
				if ($rowAbsent['total'] != 0) {
					$dataAssistance[utf8_decode('Ausentes')] = $rowAbsent['total'];
				}
			}
		}
	}
}

//Create Total Diagram
$pdf->addDiagram('Total de Presencia', $dataAssistance);

$dataaward = array();

$sqlaward    = "SELECT name FROM award";
$resultaward = $connection->query($sqlaward);
if ($resultaward->num_rows > 0) {
	while ($rowaward = $resultaward->fetch_assoc()) {
		$sqlTotal    = "SELECT count(*) as total FROM awarded a, award d WHERE a.idaward = d.idaward AND d.name = '" . $rowaward['name'] . "'";
		$resultTotal = $connection->query($sqlTotal);
		if ($resultTotal->num_rows > 0) {
			while ($rowTotal = $resultTotal->fetch_assoc()) {
				if ($rowTotal['total'] != 0) {
					$dataaward[utf8_decode($rowaward['name'])] = $rowTotal['total'];
				}
			}
		}
	}
}

//Create Total Diagram
$pdf->addDiagram('Total de Galardonados', $dataaward);

// $specificData = array();

foreach ($dataaward as $i => $value) {
	$sqlProcedency    = "SELECT name FROM procedency";
	$resultProcedency = $connection->query($sqlProcedency);
	if ($resultProcedency->num_rows > 0) {
		$dataProcedency = array();
		while ($rowProcedency = $resultProcedency->fetch_assoc()) {
			$sqlTotal    = "SELECT count(*) as total FROM awarded a, procedency p, award d WHERE a.idProcedency = p.idProcedency AND a.idaward = d.idaward AND p.name = '" . $rowProcedency['name'] . "' AND d.name = '" . utf8_encode($i) . "'";
			$resultTotal = $connection->query($sqlTotal);
			if ($resultTotal->num_rows > 0) {
				while ($rowTotal = $resultTotal->fetch_assoc()) {
					if ($rowTotal['total'] != 0) {
						$dataProcedency[utf8_decode($rowProcedency['name'])] = $rowTotal['total'];
					}
				}
			}
		}
		if (!empty($dataProcedency)) {
			//Create Total Diagram
			$pdf->addDiagram($i, $dataProcedency);
		}
	}
}

$pdf->Output();

?>