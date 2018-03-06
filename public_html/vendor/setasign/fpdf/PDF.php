<?php
require('fpdf.php');

class PDF extends FPDF
{
		// Load data
	function LoadData($file){
			// Read file lines
			$lines = file($file);
			$data = array();
			foreach($lines as $line)
				$data[] = explode(';',trim($line));
			return $data;
		}

		// Better table
	function ImprovedTable($header, $data){
			// Column widths
			$w = array(40, 35, 40, 45);
			// Header
			for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],7,$header[$i],1,0,'C');
			$this->Ln();
			// Data
			foreach($data as $row)
			{
				$this->Cell($w[0],6,$row[0],'');
				$this->Cell($w[1],6,$row[1],'');
				$this->Cell($w[2],6,number_format($row[2]),'',0,'R');
				$this->Cell($w[3],6,number_format($row[3]),'',0,'R');
				$this->Ln();
			}
			// Closing line
			$this->Cell(array_sum($w),0,'','T');
		}

		// Colored table
	function ElementsForfait($header, $data){
		// Colors, line width and bold font
		/*$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);*/
		$this->SetLineWidth(.3);
		$this->SetFont('','I');
		// Header
		$w = array(35, 30, 75, 30);
			$this->Cell(10,7,'','LR',0,'C',false);
		for($i=0;$i<count($header);$i++){
			$this->SetFont('Times','IB');
			$this->SetTextColor(31,73,125);
			$this->Cell($w[$i],7,$header[$i],'TB',0,'C',false);
		}
		$this->SetFont('Times','');
		$this->SetTextColor(0,0,0);
		$this->Cell(10,7,'','RL',0,'C',false);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$this->SetFont('','');
		foreach($data as $row)
		{
			$this->Cell(10,6,'','LR',0,'C',false);
			$this->Cell($w[0],6,$row[0],'BRL',0,'R',false);
			$this->Cell($w[1],6,number_format($row[1]),'BR',0,'R',false);
			$this->Cell($w[2],6,number_format($row[2]).'€','BR',0,'R',false);
			$this->Cell($w[3],6,number_format($row[3]).'€','BR',0,'R',false);
			$this->Cell(10,6,'','RL',0,'C',false);
			$this->Ln();
		}
		$this->Cell(190,6,'','LR',0,'L',0);
		$this->Ln();
	}

	// Colored table
	function ElementsHorsForfait($header, $data){
		$this->SetFont('','IB');
		$this->SetLineWidth(0);
		// Header
		$w = array(30, 110, 30);
		$this->Cell(10,7,'', 'L',0,'C',false);
		$this->SetTextColor(31,73,125);
		$this->Cell(170,7,'Autres Frais',0,0,'C',false);
		$this->Cell(10,7,'', 'R',0,'C',false);
		$this->Ln();
		$this->Cell(10,7,'','LR',0,'C',false);
		for($i=0;$i<count($header);$i++){
			$this->SetFont('Times','IB');
			$this->SetDrawColor(31, 73, 125);
			$this->SetTextColor(31,73,125);
			switch($i){
				case 0:
					$this->Cell($w[$i],7,$header[$i],'LTB',0,'C',false);
					break;
				case (count($header)-1):
					$this->Cell($w[$i],7,$header[$i],'RTB',0,'C',false);
					break;
				default:
					$this->Cell($w[$i],7,$header[$i],'TB',0,'C',false);
					break;
			}
			$this->SetFont('Times','');
		}
		$this->SetDrawColor(0, 0, 0);
		$this->Cell(10,7,'','RL',0,'C',false);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$this->SetFont('','');
		foreach($data as $row){
			$this->Cell(10,6,'','L',0,'C',false);
			$this->SetDrawColor(31, 73, 125);
			$this->Cell($w[0],6,$row[0],'BRL',0,'L',false);
			$this->Cell($w[1],6,$row[1],'BRL',0,'L',false);
			$this->Cell($w[2],6,number_format($row[2]).'€','RLB',0,'R',false);
			$this->SetDrawColor(0,0,0);
			$this->Cell(10,6,'','R',0,'C',false);
			$this->Ln();
		}
		$this->Cell(190,7,'','LBR',0,'C',false);
		$this->Ln(10);
	}
	
	function HeaderInfosPerso($data){
		$this->Image('logo.jpg', 190/2);
		/*$this->SetFont('Times');
		$this->SetFontSize(13.5);*/
		$this->Cell(190,2,'',0,0,'C',0);
		$this->Ln();
		$this->SetTextColor(31,73,125);
		$this->Cell(190,6,'Etat de frais Engagés','LRT',0,'C',0);
		$this->Ln();
		/*$this->SetFont('calibri');*/
		$this->SetFontSize(11);
		$this->SetTextColor(94,140,195);
		$this->SetFont('','BI');
		$this->Cell(190,6,'A retourner accompagné des justificatifs au plus tard le 10 du mois qui suit l’engagement des frais','LR',0,'R',0);
		$this->SetFont('','');
		$this->Ln();
		$w = array(10, 30, 22.5, 117.5);
		$this->Cell($w[0],6,'','L',0,'C',0);
		$this->SetTextColor(94,140,195);
		$this->SetFont('','B');
		$this->Cell($w[1],6,'Visiteur','',0,'L',0);
		$this->SetFont('','');
		$this->SetTextColor(0,0,0);
		$this->Cell($w[2],6,'Matricule','',0,'L',0);
		$this->Cell($w[3],6,$data['matricule'],'B',0,'L',0);
		$this->Cell($w[0],6,'','R',0,'L',0);
		$this->Ln();
		
		$this->Cell($w[0],6,'','L',0,'L',0);
		$this->Cell($w[1],6,'','',0,'L',0);
		$this->Cell($w[2],6,'Nom','',0,'L',0);
		$this->Cell($w[3],6,$data['nom'],'B',0,'L',0);
		$this->Cell($w[0],6,'','R',0,'L',0);
		$this->Ln();
		
		$this->Cell($w[0],6,'','L',0,'L',0);
		$this->SetTextColor(94,140,195);
		$this->SetFont('','B');
		$this->Cell($w[1],6,'Mois','',0,'L',0);
		$this->SetFont('','');
		$this->SetTextColor(0,0,0);
		$this->Cell($w[2],6,$data['mois'],'B',0,'L',0);
		$this->Cell($w[3],6,'','',0,'L',0);
		$this->Cell($w[0],6,'','R',0,'L',0);
		$this->Ln();
			
		$this->Cell($w[0],6,'','L',0,'L',0);
		$this->Cell($w[1],6,'','',0,'L',0);
		$this->Cell($w[2],6,'','',0,'L',0);
		$this->Cell($w[3],6,'','',0,'L',0);
		$this->Cell($w[0],6,'','R',0,'L',0);
		$this->Ln();
	}
		
	function Signature(){
		$this->SetTextColor(31,73,125);
		$this->SetFont('Times','IB');
		$this->SetFontSize(11);
		$this->Cell(190,4,'Signature',0,0,'R',0);
		$this->SetTextColor(0,0,0);
		$this->SetFont('','');
	}
		
		   /************************************************************
    *                                                           *
    *    MultiCell with bullet (array)                          *
    *                                                           *
    *    Requires an array with the following  keys:            *
    *                                                           *
    *        Bullet -> String or Number                         *
    *        Margin -> Number, space between bullet and text    *
    *        Indent -> Number, width from current x position    *
    *        Spacer -> Number, calls Cell(x), spacer=x          *
    *        Text -> Array, items to be bulleted                *
    *                                                           *
    ************************************************************/

    function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false){
        if (!is_array($blt_array))
        {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }
                
        //Save x
        $bak_x = $this->x;
        print_r($fill);
        for ($i=0; $i<sizeof($blt_array['text']); $i++)
        {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
            
            // SetX
            $this->SetX($bak_x);
            
            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);
            
            //Output bullet
            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
            
            //Output text
            $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
            
            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text'])-1)
                $this->Ln($blt_array['spacer']);
            
            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet']++;
        }
    
        //Restore x
        $this->x = $bak_x;
    }
		
	function Footer(){
		$column_width = $this->w-30;
		$lines = array();
		$lines['bullet'] = chr(149);
		$lines['margin'] = ' ';
		$lines['indent'] = 0;
		$lines['spacer'] = 0;
		$lines['text'][0] = "(Véhicule  4CV Diesel) 	0.52 € / Km";
		$lines['text'][1] = "(Véhicule 5/6CV Diesel) 	0.58 € / Km";
		$lines['text'][2] = "(Véhicule  4CV Essence) 	0.62 € / Km";
		$lines['text'][3] = "(Véhicule 5/6CV Essence) 	0.67 € / Km";
		// Go to 1.5 cm from bottom
		$this->SetY(-50);
		// Select Arial italic 8
		$this->SetFont('times','I',10);
		// Print centered page number
		$this->Cell(0,4,'1 Les frais forfaitaires doivent être justifiés par une facture acquittée faisant apparaître le montant de la TVA.','T',0,false);
		$this->Ln();
		$this->Cell(0,4,'Ces documents ne sont pas à joindre à l’état de frais mais doivent être conservés pendant trois années. Ils',0,0,false);
		$this->Ln();
		$this->Cell(0,4,'peuvent être contrôlés par le délégué régional ou le service comptable',0,0,false);
		$this->Ln();
		$this->Cell(0,4,"2 Tarifs en vigueur au 01/09/2017",0,0,'L',0);
		$this->Ln();
		$this->Cell(0,4,"3 Prix au kilomètre en fonction du véhicule déclaré auprès des services comptables	",0,0,'L',0);
		$this->Ln();
		$this->MultiCellBltArray($column_width-$this->x,6,$lines);
		$this->Cell(0,4,"4 Tout frais « hors forfait » doit être dûment justifié par l’envoi d’une facture acquittée faisant apparaître le montant de TVA",0,0,'L',0);
	}
}

	$pdf = new PDF();

	// Column headings
	$info = array("matricule"=>"a131", "nom"=>"L. VilleNeuve", "mois"=>"Janv. 2017");
	$header = array('Date', 'Libellé', 'Montant');
	$header2 = array('Fraits forfaitaires', 'Quantité', 'Montant Unitaire', 'Total');
	// Data loading
	$data = $pdf->LoadData('countries.txt');
	$data2 = $pdf->LoadData('elementsForfait.txt');
	$pdf->SetFont('Arial','',14);
	$pdf->AddPage();
	$pdf->HeaderInfosPerso($info);
	$pdf->ElementsForfait($header2,$data2);
	$pdf->ElementsHorsForfait($header,$data);
	$pdf->Signature();
	$pdf->Output();
?>