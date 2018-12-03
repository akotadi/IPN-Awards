<?php
require 'fpdf.php';

class PDF extends FPDF {

	protected $B    = 0;
	protected $I    = 0;
	protected $U    = 0;
	protected $HREF = '';

	function __construct($orientation, $unit, $size) {
		parent::__construct($orientation, $unit, $size);
	}

// Page footer
	function Footer() {
		// Position at 1.5 cm from bottom
		$this->SetY(-8);
		$this->SetFont('Arial', 'B', 10);
		$this->SetTextColor(249, 178, 69);
		$this->Write(5, "INFORMES: ");
		$this->SetFont('', 'U');
		$this->SetTextColor(0, 0, 0);
		$this->Write(5, 'www.sg.ipn.mx', 'http://www.sg.ipn.mx');
		$this->SetXY(195 - $this->GetStringWidth('www.ipn.mx'), -8);
		$this->Write(5, 'www.ipn.mx', 'http://www.ipn.mx');
	}
}
?>