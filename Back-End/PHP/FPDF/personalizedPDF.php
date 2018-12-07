<?php
require 'diag.php';

//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000") {
	$R                = substr($couleur, 1, 2);
	$rouge            = hexdec($R);
	$V                = substr($couleur, 3, 2);
	$vert             = hexdec($V);
	$B                = substr($couleur, 5, 2);
	$bleu             = hexdec($B);
	$tbl_couleur      = array();
	$tbl_couleur['R'] = $rouge;
	$tbl_couleur['V'] = $vert;
	$tbl_couleur['B'] = $bleu;
	return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px) {
	return $px * 25.4 / 72;
}

function txtentities($html) {
	$trans = get_html_translation_table(HTML_ENTITIES);
	$trans = array_flip($trans);
	return strtr($html, $trans);
}

class PDF extends PDF_Diag {

	protected $B    = 0;
	protected $I    = 0;
	protected $U    = 0;
	protected $HREF = '';
	protected $fontList;
	protected $issetfont;
	protected $issetcolor;
	protected $tableborder;
	protected $tdbegin;
	protected $tdwidth;
	protected $tdheight;
	protected $tdalign;
	protected $tdbgcolor;
	protected $oldx;
	protected $oldy;

	function __construct($orientation, $unit, $size) {
		parent::__construct($orientation, $unit, $size);
		//Initialization
		$this->B    = 0;
		$this->I    = 0;
		$this->U    = 0;
		$this->HREF = '';

		$this->tableborder = 0;
		$this->tdbegin     = false;
		$this->tdwidth     = 0;
		$this->tdheight    = 0;
		$this->tdalign     = "L";
		$this->tdbgcolor   = false;

		$this->oldx = 0;
		$this->oldy = 0;

		$this->fontlist   = array("arial", "times", "courier", "helvetica", "symbol");
		$this->issetfont  = false;
		$this->issetcolor = false;
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

	function addaward($award, $speech) {
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

	function addarea($area) {
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

	function WriteHTML($html) {
		$html = strip_tags($html, "<b><u><i><a><img><p><br><strong><em><font><tr><blockquote><hr><td><tr><table><sup>"); //remove all unsupported tags
		$html = str_replace("\n", '', $html); //replace carriage returns with spaces
		$html = str_replace("\t", '', $html); //replace carriage returns with spaces
		$a    = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE); //explode the string
		foreach ($a as $i => $e) {
			if ($i % 2 == 0) {
				//Text
				if ($this->HREF) {
					$this->PutLink($this->HREF, $e);
				} elseif ($this->tdbegin) {
					if (trim($e) != '' && $e != "&nbsp;") {
						$this->Cell($this->tdwidth, $this->tdheight, $e, $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
					} elseif ($e == "&nbsp;") {
						$this->Cell($this->tdwidth, $this->tdheight, '', $this->tableborder, '', $this->tdalign, $this->tdbgcolor);
					}
				} else {
					$this->Write(5, stripslashes(txtentities($e)));
				}

			} else {
				//Tag
				if ($e[0] == '/') {
					$this->CloseTag(strtoupper(substr($e, 1)));
				} else {
					//Extract attributes
					$a2   = explode(' ', $e);
					$tag  = strtoupper(array_shift($a2));
					$attr = array();
					foreach ($a2 as $v) {
						if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3)) {
							$attr[strtoupper($a3[1])] = $a3[2];
						}

					}
					$this->OpenTag($tag, $attr);
				}
			}
		}
	}

	function OpenTag($tag, $attr) {
		//Opening tag
		switch ($tag) {

		case 'SUP':
			if (!empty($attr['SUP'])) {
				//Set current font to 6pt
				$this->SetFont('', '', 6);
				//Start 125cm plus width of cell to the right of left margin
				//Superscript "1"
				$this->Cell(2, 2, $attr['SUP'], 0, 0, 'L');
			}
			break;

		case 'TABLE': // TABLE-BEGIN
			if (!empty($attr['BORDER'])) {
				$this->tableborder = $attr['BORDER'];
			} else {
				$this->tableborder = 0;
			}

			break;
		case 'TR': //TR-BEGIN
			break;
		case 'TD': // TD-BEGIN
			if (!empty($attr['WIDTH'])) {
				$this->tdwidth = ($attr['WIDTH'] / 4);
			} else {
				$this->tdwidth = 40;
			}
			// Set to your own width if you need bigger fixed cells
			if (!empty($attr['HEIGHT'])) {
				$this->tdheight = ($attr['HEIGHT'] / 6);
			} else {
				$this->tdheight = 6;
			}
			// Set to your own height if you need bigger fixed cells
			if (!empty($attr['ALIGN'])) {
				$align = $attr['ALIGN'];
				if ($align == 'LEFT') {
					$this->tdalign = 'L';
				}

				if ($align == 'CENTER') {
					$this->tdalign = 'C';
				}

				if ($align == 'RIGHT') {
					$this->tdalign = 'R';
				}

			} else {
				$this->tdalign = 'L';
			}
			// Set to your own
			if (!empty($attr['BGCOLOR'])) {
				$coul = hex2dec($attr['BGCOLOR']);
				$this->SetFillColor($coul['R'], $coul['G'], $coul['B']);
				$this->tdbgcolor = true;
			}
			$this->tdbegin = true;
			break;

		case 'HR':
			if (!empty($attr['WIDTH'])) {
				$Width = $attr['WIDTH'];
			} else {
				$Width = $this->w - $this->lMargin - $this->rMargin;
			}

			$x = $this->GetX();
			$y = $this->GetY();
			$this->SetLineWidth(0.2);
			$this->Line($x, $y, $x + $Width, $y);
			$this->SetLineWidth(0.2);
			$this->Ln(1);
			break;
		case 'STRONG':
			$this->SetStyle('B', true);
			break;
		case 'EM':
			$this->SetStyle('I', true);
			break;
		case 'B':
		case 'I':
		case 'U':
			$this->SetStyle($tag, true);
			break;
		case 'A':
			$this->HREF = $attr['HREF'];
			break;
		case 'IMG':
			if (isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
				if (!isset($attr['WIDTH'])) {
					$attr['WIDTH'] = 0;
				}

				if (!isset($attr['HEIGHT'])) {
					$attr['HEIGHT'] = 0;
				}

				$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
			}
			break;
		case 'BLOCKQUOTE':
		case 'BR':
			$this->Ln(5);
			break;
		case 'P':
			$this->Ln(10);
			break;
		case 'FONT':
			if (isset($attr['COLOR']) && $attr['COLOR'] != '') {
				$coul = hex2dec($attr['COLOR']);
				$this->SetTextColor($coul['R'], $coul['G'], $coul['B']);
				$this->issetcolor = true;
			}
			if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
				$this->SetFont(strtolower($attr['FACE']));
				$this->issetfont = true;
			}
			if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist) && isset($attr['SIZE']) && $attr['SIZE'] != '') {
				$this->SetFont(strtolower($attr['FACE']), '', $attr['SIZE']);
				$this->issetfont = true;
			}
			break;
		}
	}

	function CloseTag($tag) {
		//Closing tag
		if ($tag == 'SUP') {
		}

		if ($tag == 'TD') {
			// TD-END
			$this->tdbegin   = false;
			$this->tdwidth   = 0;
			$this->tdheight  = 0;
			$this->tdalign   = "L";
			$this->tdbgcolor = false;
		}
		if ($tag == 'TR') {
			// TR-END
			$this->Ln();
		}
		if ($tag == 'TABLE') {
			// TABLE-END
			$this->tableborder = 0;
		}

		if ($tag == 'STRONG') {
			$tag = 'B';
		}

		if ($tag == 'EM') {
			$tag = 'I';
		}

		if ($tag == 'B' || $tag == 'I' || $tag == 'U') {
			$this->SetStyle($tag, false);
		}

		if ($tag == 'A') {
			$this->HREF = '';
		}

		if ($tag == 'FONT') {
			if ($this->issetcolor == true) {
				$this->SetTextColor(0);
			}
			if ($this->issetfont) {
				$this->SetFont('arial');
				$this->issetfont = false;
			}
		}
	}

	function SetStyle($tag, $enable) {
		//Modify style and select corresponding font
		$this->$tag += ($enable ? 1 : -1);
		$style = '';
		foreach (array('B', 'I', 'U') as $s) {
			if ($this->$s > 0) {
				$style .= $s;
			}

		}
		$this->SetFont('', $style);
	}

	function PutLink($URL, $txt) {
		//Put a hyperlink
		$this->SetTextColor(0, 0, 255);
		$this->SetStyle('U', true);
		$this->Write(5, $txt, $URL);
		$this->SetStyle('U', false);
		$this->SetTextColor(0);
	}

}
?>