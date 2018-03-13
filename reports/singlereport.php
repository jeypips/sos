<?php

$params = json_decode($_POST['params'],true);

require('../fpdf181/fpdf.php');
require('../db.php');

class PDF extends FPDF {

	function CheckPageBreak($h) {
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);		
		}
	}

	function NbLines($w,$txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0) $w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n") $nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb) {
			$c=$s[$i];
			if($c=="\n") {
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ') $sep=$i;
			$l+=$cw[$c];
			if($l>$wmax) {
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}	
	
	// Page header
	function Header() {
		
		global $top_margin, $header; # array-multi
		
		$this->Ln($top_margin);		
		if ($this->PageNo()>1) {
			if ($top_margin <= 5) $top_margin+=5;
			$this->Ln($top_margin);
		}
		
		foreach ($header as $h) {
			$h($this);
		};		

	}

	// Page footer
	function Footer() {
		global $footer;
		
		foreach ($footer as $f) {
			$f($this);
		};
		
		// Position at 1.5 cm from bottom	
		$this->SetY(-10);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Page number
		$this->SetTextColor(66,66,66);	
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'L');
	}
	
	function body($body) {
		
		$body['start']($this); # start
		$lr_margin = $body['lr_margin'];		
		$headers = $body['headers'];
		$data = $body['data'];

		$this->SetMargins($lr_margin,0);
		$this->Cell(0,5,"",0,1,'L');
		
		// Calculate the height of the header
		$nb=0;
		foreach ($headers as $h) {
			$nb=max($nb,$this->NbLines($h['width'],$h['column']));
		}
		$hh=5*$nb;
	
		// Header
		$header_y = $this->GetY();
		$header_x = $this->GetX();
		$x_stack = 0;
		foreach ($headers as $i => $h) {
			if ($i > 0) {
				$x_stack += $headers[$i-1]['width'];
				$this->SetY($header_y);
				$header_x = $lr_margin+$x_stack;
				$this->SetX($header_x);
			}
			$this->Rect($header_x,$header_y,$h['width'],$hh,'DF');
			// $this->MultiCell($h['width'],7,$h['column'],1,'C',true);
			$this->MultiCell($h['width'],5,$h['column'],0,'C');
		}
		$this->Ln($hh-5);
		
		$fill = false;
		$body['striped_bg']($this);
		foreach($data as $key => $row) {			
			
			// Calculate the height of each body row
			$nb=0;
			foreach ($headers as $i => $h) {
				$nb=max($nb,$this->NbLines($h['width'],$row[array_keys($row)[$i]]));
			}
			$rh=5*$nb;
			
			$this->CheckPageBreak($rh);
			
			$body_y = $this->GetY();
			$body_x = $this->GetX();		
			$x_stack = 0;
			foreach ($headers as $i => $h) {
				if ($i > 0) {
					$x_stack += $headers[$i-1]['width'];
					$this->SetY($body_y);
					$body_x = $lr_margin+$x_stack;
					$this->SetX($body_x);
				}
				$df = 'D';
				if ($body['striped']) if ($fill) $df = 'DF';
				$this->Rect($body_x,$body_y,$h['width'],$rh,$df);
				// $this->MultiCell($h['width'],5,$row[array_keys($row)[$i]],0,'C',$fill);
				$this->MultiCell($h['width'],5,$row[array_keys($row)[$i]],0,'C');
			}
			
			if ($key > 0) $this->Ln($rh-5);		
			$fill = !$fill;
			
		}		
		
	}

}

# start

$top_margin = 5;
$body_top_margin = 0;

$header = array(
	function($p) {
		echo null; # important in include
		$p->SetFont('Arial','B',12);
		$p->SetTextColor(66,66,66);
		$p->Cell(0,5,"LUCST",0,1,'C');	
		$p->Cell(0,5,"STUDENTS",0,1,'C');	
	},
	function($p) { # always last item
		echo null; # important in include
		global $body_top_margin;
		$p->Ln($body_top_margin);		
		if ($p->PageNo()>1) {
			if ($body_top_margin <= 2) $body_top_margin+=5;
			$p->Ln($body_top_margin);
		}
	}
);

$footer = array(
	function($p) {
		echo null; # important in include
	}
);

$headers = array(
	array("width"=>20,"column"=>"ID Number"),
	array("width"=>50,"column"=>"First Name"),
	array("width"=>50,"column"=>"Last Name"),
	array("width"=>50,"column"=>"Educational Level"),
	array("width"=>15,"column"=>"Grade"),
	array("width"=>20,"column"=>"Section")
);

# query here

$con = new pdo_db();

$operators = array(
	"id_number"=>"=",
	"firstname"=>"=",
	"lastname"=>"=",
	"educational_level"=>"=",
	"grade"=>"=",
	"section"=>"="
);

$filter = "";
$i = 0;
foreach ($params as $column => $param) {
	$operator = "=";
	if (isset($operators[$column])) $operator = $operators[$column];
	if ($i == 0) $filter .= " WHERE $column $operator '$param'";
	else $filter .= " AND $column $operator '$param'";
	$i++;
};

$sql = "SELECT id_number, firstname, lastname, educational_level, grade, section FROM students $filter";
$data = $con->getData($sql);

#

$body = array(
	"lr_margin"=>5,
	"striped"=>true,
	"striped_bg"=>function($p) {
		$p->SetFillColor(223,223,223); # background color		
	},
	"headers"=>$headers,
	"data"=>$data,
	"start"=>function($p) {
		echo null; # important in include
		// Colors, line width and bold font
		$p->SetDrawColor(92,92,92); # border color
		$p->SetFillColor(60,159,223); # background color
		$p->SetTextColor(66,66,66); # font color
		$p->SetLineWidth(.1); # border width
		$p->SetFont('Arial','B',8);
	}
);

# end

$pdf = new PDF('P','mm','Letter'); # set here if Portrait(P)/Landscape(L)
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->body($body);
$pdf->Output();

?>