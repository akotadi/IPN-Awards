<?php
require 'diag.php';

class PDF extends PDF_Diag {

	protected $B    = 0;
	protected $I    = 0;
	protected $U    = 0;
	protected $HREF = '';

	function __construct($orientation, $unit, $size) {
		parent::__construct($orientation, $unit, $size);
	}

// Page header
	function Header() {
		// Line break
		$this->Image('IPN.png', 100, 0, 100, 0, 'PNG'); // Put an image
		$this->SetFont('Arial', 'B', 24);
		$this->SetTextColor(124, 125, 127);
		$this->Cell(0, 10, 'GALARDONES IPN', 0, 0);
		$this->Ln(20);
	}

// Page footer
	function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial', 'I', 8);
		// Page number
		// $this->Image('ipn-logo.png', 10, 12, 30, 0, '', 'http://www.fpdf.org');
		$this->AliasNbPages('{totalPages}');
		$this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{totalPages}', 0, 1, 'C');
	}

	function addTitle($title) {
		// Arial bold 15
		$this->SetFont('Arial', 'B', 15);
		// Calculate width of title and position
		$w = $this->GetStringWidth($title) + 6;
		$this->SetX((210 - $w) / 2);
		// Colors of frame, background and text
		// $this->SetDrawColor(0, 80, 180);
		// $this->SetFillColor(230, 230, 0);
		$this->SetTextColor(220, 50, 50);
		// Thickness of frame (1 mm)
		// $this->SetLineWidth(1);
		// Title
		$this->Cell($w, 9, $title, 1, 1, 'C');
		// Line break
		// $this->Ln(10);
	}

	function addSubTitle($title) {
		// Arial bold 15
		$this->SetFont('Arial', 'B', 13);
		// Calculate width of title and position
		$w = $this->GetStringWidth($title) + 6;
		$this->SetX((210 - $w) / 2);
		// Colors of frame, background and text
		// $this->SetDrawColor(0, 80, 180);
		// $this->SetFillColor(230, 230, 0);
		$this->SetTextColor(0, 0, 0);
		// Thickness of frame (1 mm)
		// $this->SetLineWidth(1);
		// Title
		$this->Cell($w, 9, $title, 1, 1, 'C');
		// Line break
		$this->Ln(10);
	}

	function addAward($award, $speech) {
		$this->Ln(4);
		$this->SetTextColor(0, 0, 0);
		// Arial 12
		$this->SetFont('Arial', '', 14);
		// Background color
		$this->SetFillColor(200, 220, 255);
		// Title
		$this->Cell(0, 6, $award, 0, 1, 'L', true);
		// Line break
		$this->Ln(4);

		// Times 12
		$this->SetFont('Arial', '', 12);
		// Output justified text
		$this->MultiCell(0, 5, $speech);
		// Line break
		$this->Ln(2);
	}

	function addArea($area) {
		$this->SetTextColor(0, 0, 0);
		// Times 12
		$this->SetFont('Arial', '', 11);
		// Output justified text
		$this->MultiCell(0, 5, $area);
		// Line break
		$this->Ln();
	}

	function addProcedency($procedency) {
		$this->SetTextColor(0, 0, 0);
		// Times 12
		$this->SetFont('Arial', '', 10);
		// Output justified text
		$this->MultiCell(0, 5, $procedency);
		// Line break
		$this->Ln();
	}

	function addName($name) {
		$this->SetTextColor(0, 0, 0);
		// Times 12
		$this->SetFont('Arial', '', 8);
		// Output justified text
		$this->MultiCell(0, 5, $name);
		// Line break
		$this->Ln();
	}

	function addDiagram($title, $data) {
		$this->AddPage();
		$valY = $this->GetY();
		$this->SetXY(10, $valY);
		$this->SetFont('Arial', 'BIU', 12);
		$this->Cell(0, 5, $title, 0, 1);
		$this->Ln(8);
		$valX = $this->GetX();
		$valY = $this->GetY();
		$this->SetXY(10, $valY);
		$colors = array();
		foreach ($data as $i => $value) {
			array_push($colors, array(mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255)));
		}
		$this->PieChart(190, 100, $data, '%l (%p)', $colors);
		$valY = $this->GetY();
		$this->SetXY($valX, $valY + 60);
		$this->SetFont('Arial', 'BIU', 12);
		$this->BarDiagram(190, 70, $data, '%l : %v (%p)', array(mt_rand(0, 255), mt_rand(0, 255), 100));
		$valX = $this->GetX();
		$valY = $this->GetY();
		$this->SetXY($valX, $valY + 40);
	}
}
?>