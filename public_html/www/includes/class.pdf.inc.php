<?php
//Changement de contexte : la page devient pdf
?>
<?php
//Inclusion de la classe mère fpdf
require('../../vendor/setasign/fpdf/fpdf.php');

class PDF extends FPDF {

    //Entitées
    private $_ficheFraisTab = array(); //Le tableau des fiches de frais
    private $_idVisiteur = ""; //Le matricule du visiteur
    private $_nomComplet = ""; //Le nom complet du visiteur
    private $_fileName = ""; //Nom de fichier PDF à exporter
    
    
    //Constantes
    const DEFAULT_OUTPUT_FILE_LOCATION = "../pdfOutput/ficheFrais.pdf";

    /**
     * Range les éléments forfaitisés dans un tableau pdf
     * @param type $header les entêtes du tableau
     * @param type $data les données forfaitisées
     */
    function ElementsForfait($header, $data) {
        // Colors, line width and bold font
        /* $this->SetFillColor(255,0,0);
          $this->SetTextColor(255);
          $this->SetDrawColor(128,0,0); */
        $this->SetLineWidth(.3);
        $this->SetFont('', 'I');
        // Header
        $w = array(35, 30, 75, 30);
        $this->Cell(10, 7, '', 'LR', 0, 'C', false);
        for ($i = 0; $i < count($header); $i++) {
            $this->SetFont('Times', 'IB');
            $this->SetTextColor(31, 73, 125);
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 'TB', 0, 'C', false);
        }
        $this->SetFont('Times', '');
        $this->SetTextColor(0, 0, 0);
        $this->Cell(10, 7, '', 'RL', 0, 'C', false);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $this->SetFont('', '');
        foreach($data as $row){
            $this->Cell(10, 7, '', 'LR', 0, 'C', false);
            $this->Cell($w[0], 7, utf8_decode($row['idfraisforfait']), 'BRL', 0, 'R', false);
            $this->Cell($w[1], 7, number_format($row['quantite']), 'BR', 0, 'R', false);
            $this->Cell($w[2], 7, number_format($row['montantunitaire']/$row['quantite']) . utf8_decode(utf8_encode(chr(128))), 'BR', 0, 'R', false);
            $this->Cell($w[3], 7, number_format($row['somme']) . utf8_decode(utf8_encode(chr(128))), 'BR', 0, 'R', false);
            $this->Cell(10, 7, '', 'RL', 0, 'C', false);
            $this->Ln();
        }
        $this->Cell(10, 6, '', 'L', 0, 'C', false);
        $this->Cell(180, 6, '', 'R', 0, 'C', false);
        $this->Ln();
        $this->Cell(10, 6, '', 'L', 0, 'C', false);
        $this->Cell(180, 6, '', 'R', 0, 'C', false);
        $this->Ln();
        
    }

    /**
     * Range les élements hors-forfaits dans un tableau pour le fichier pdf
     * @param type $header l'entête des champs du tableau
     * @param type $data les frais hors-forfait
     */
    function ElementsHorsForfait($header, $data) {
        $this->SetFont('', 'IB');
        $this->SetLineWidth(0);
        // Header
        $w = array(30, 110, 30);
        $this->Cell(10, 7, '', 'L', 0, 'C', false);
        $this->SetTextColor(31, 73, 125);
        $this->Cell(170, 7, 'Autres Frais', 0, 0, 'C', false);
        $this->Cell(10, 7, '', 'R', 0, 'C', false);
        $this->Ln();
        $this->Cell(10, 7, '', 'LR', 0, 'C', false);
        for ($i = 0; $i < count($header); $i++) {
            $this->SetFont('Times', 'IB');
            $this->SetDrawColor(31, 73, 125);
            $this->SetTextColor(31, 73, 125);
            switch (true) {
                case ($i == 0):
                    $this->Cell($w[$i], 7, utf8_decode($header[$i]), 'LTB', 0, 'C', false);
                    break;
                case($i == count($header)-1):
                    $this->Cell($w[$i], 7, utf8_decode($header[$i]), 'RTB', 0, 'C', false);
                    break;
                case($i >0 && $i<count($header)-1):
                    $this->Cell($w[$i], 7, utf8_decode($header[$i]), 'TB', 0, 'C', false);
                    break;
                default:
                    break;
            }
            $this->SetFont('Times', '');
        }
        $this->SetDrawColor(0, 0, 0);
        $this->Cell(10, 7, '', 'RL', 0, 'C', false);
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $this->SetFont('', '');
        foreach ($data as $row) {
            $this->Cell(10, 6, '', 'L', 0, 'C', false);
            $this->SetDrawColor(31, 73, 125);
            $this->Cell($w[0], 6, $row['date'], 'BRL', 0, 'L', false);
            $this->Cell($w[1], 6, $row['libelle'], 'BRL', 0, 'L', false);
            $this->Cell($w[2], 6, number_format($row['montant']).utf8_decode(utf8_encode(chr(128))), 'RLB', 0, 'R', false);
            $this->SetDrawColor(0, 0, 0);
            $this->Cell(10, 6, '', 'R', 0, 'C', false);
            $this->Ln();
        }
        $this->Cell(190, 7, '', 'LBR', 0, 'C', false);
        $this->Ln(10);
    }
    
    /**
     * Création de la partie des informations de base
     * @param type $data
     */
    function HeaderInfosPerso($data) {
        $this->Image('../images/logo.jpg', 190 / 2);
        /* $this->SetFont('Times');
          $this->SetFontSize(13.5); */
        $this->Cell(190, 2, '', 0, 0, 'C', 0);
        $this->Ln();
        $this->SetTextColor(31, 73, 125);
        $this->Cell(190, 6, utf8_decode('Etat de frais Engagés'), 'LRT', 0, 'C', 0);
        $this->Ln();
        /* $this->SetFont('calibri'); */
        $this->SetFontSize(11);
        $this->SetTextColor(94, 140, 195);
        $this->SetFont('', 'BI');
        $this->Cell(190, 6, utf8_decode("A retourner accompagne des justificatifs au plus tard le 10 du mois qui suit l'engagement des frais"), 'LR', 0, 'R', 0);
        $this->SetFont('', '');
        $this->Ln();
        $w = array(10, 30, 22.5, 117.5);
        $this->Cell($w[0], 6, '', 'L', 0, 'C', 0);
        $this->SetTextColor(94, 140, 195);
        $this->SetFont('', 'B');
        $this->Cell($w[1], 6, 'Visiteur', '', 0, 'L', 0);
        $this->SetFont('', '');
        $this->SetTextColor(0, 0, 0);
        $this->Cell($w[2], 6, 'Matricule', '', 0, 'L', 0);
        $this->Cell($w[3], 6, $data['matricule'], 'B', 0, 'L', 0);
        $this->Cell($w[0], 6, '', 'R', 0, 'L', 0);
        $this->Ln();

        $this->Cell($w[0], 6, '', 'L', 0, 'L', 0);
        $this->Cell($w[1], 6, '', '', 0, 'L', 0);
        $this->Cell($w[2], 6, 'Nom', '', 0, 'L', 0);
        $this->Cell($w[3], 6, $data['nom'], 'B', 0, 'L', 0);
        $this->Cell($w[0], 6, '', 'R', 0, 'L', 0);
        $this->Ln();

        $this->Cell($w[0], 6, '', 'L', 0, 'L', 0);
        $this->SetTextColor(94, 140, 195);
        $this->SetFont('', 'B');
        $this->Cell($w[1], 6, 'Mois', '', 0, 'L', 0);
        $this->SetFont('', '');
        $this->SetTextColor(0, 0, 0);
        $this->Cell($w[2], 6, $data['mois'], 'B', 0, 'L', 0);
        $this->Cell($w[3], 6, '', '', 0, 'L', 0);
        $this->Cell($w[0], 6, '', 'R', 0, 'L', 0);
        $this->Ln();

        $this->Cell($w[0], 6, '', 'L', 0, 'L', 0);
        $this->Cell($w[1], 6, '', '', 0, 'L', 0);
        $this->Cell($w[2], 6, '', '', 0, 'L', 0);
        $this->Cell($w[3], 6, '', '', 0, 'L', 0);
        $this->Cell($w[0], 6, '', 'R', 0, 'L', 0);
        $this->Ln();
    }

    /**
     * Fonction permettant la création de la partie signature
     */
    function Signature() {
        $this->SetTextColor(31, 73, 125);
        $this->SetFont('Times', 'IB');
        $this->SetFontSize(11);
        $this->Cell(190, 4, 'Signature', 0, 0, 'R', 0);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('', '');
    }

    /**
     * @author Sean Benoit <a href = "http://www.fpdf.org/en/script/script56.php">Lien vers le site</a>
     * Création d'une liste à puces
     * @param type $w
     * @param type $h
     * @param type $blt_array
     * @param type $border
     * @param type $align
     * @param type $fill
     */
    function MultiCellBltArray($w, $h, $blt_array, $border = 0, $align = 'J', $fill = false) {
        if (!is_array($blt_array)) {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }

        //Save x
        $bak_x = $this->x;
        for ($i = 0; $i < sizeof($blt_array['text']); $i++) {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin']) + $this->cMargin * 2;

            // SetX
            $this->SetX($bak_x);

            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);

            //Output bullet
            $this->Cell($blt_width, $h, $blt_array['bullet'] . $blt_array['margin'], 0, '', $fill);

            //Output text
            $this->MultiCell($w - $blt_width, $h, $blt_array['text'][$i], $border, $align, $fill);

            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text']) - 1)
                $this->Ln($blt_array['spacer']);

            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet'] ++;
        }

        //Restore x
        $this->x = $bak_x;
    }

    /**
     * Fonction de bas-de-page
     */
    function Footer() {
        $column_width = $this->w - 30;
        $lines = array();
        $lines['bullet'] = chr(149);
        $lines['margin'] = ' ';
        $lines['indent'] = 0;
        $lines['spacer'] = 0;
        $lines['text'][0] = utf8_decode("(Véhicule  4CV Diesel) 	0.52 ".utf8_encode(chr(128))."/Km");
        $lines['text'][1] = utf8_decode("(Véhicule 5/6CV Diesel) 	0.58 ".utf8_encode(chr(128))."/Km");
        $lines['text'][2] = utf8_decode("(Véhicule  4CV Essence) 	0.62 ".utf8_encode(chr(128))."/Km");
        $lines['text'][3] = utf8_decode("(Véhicule 5/6CV Essence) 	0.67 ".utf8_encode(chr(128))."/Km");
        // Go to 1.5 cm from bottom
        $this->SetY(-50);
        // Select Arial italic 8
        $this->SetFont('times', 'I', 10);
        // Print centered page number
        $this->Cell(0, 4, utf8_decode('1 Les frais forfaitaires doivent être justifiés par une facture acquittée faisant apparaitre le montant de la TVA.'), 'T', 0, false);
        $this->Ln();
        $this->Cell(0, 4, utf8_decode("Ces documents ne sont pas à joindre à l'état de frais mais doivent etre conservés pendant trois années. Ils"), 0, 0, false);
        $this->Ln();
        $this->Cell(0, 4, utf8_decode('peuvent être controlés par le délégué régional ou le service comptable'), 0, 0, false);
        $this->Ln();
        $this->Cell(0, 4, utf8_decode("2 Tarifs en vigueur au 01/09/2017"), 0, 0, 'L', 0);
        $this->Ln();
        $this->Cell(0, 4, utf8_decode("3 Prix au kilomètre en fonction du véhicule déclaré auprès des services comptables"), 0, 0, 'L', 0);
        $this->Ln();
        $this->MultiCellBltArray($column_width - $this->x, 6, $lines);
        $this->Cell(0, 4, utf8_decode("4 Tout frais hors forfait doit être dûment justifié par l'envoi d'une facture acquittée faisant apparaître le montant de TVA"), 0, 0, 'L', 0);
    }
    
    /**
     * Création de page de frais
     * @param array $ficheFrais
     * @version 0.5
     */
    function addPageFicheFrais($ficheFrais){
        $HEADER_FRAIS_FORFAITISES = array('Fraits forfaitaires', 'Quantité', 'Montant Unitaire', 'Total');
        $HEADER_FRAIS_HF = array('Date', 'Libellé', 'Montant');
        //Création des données de l'entête
        $info = array("matricule" => $this->_idVisiteur,
                      "nom" => $this->_nomComplet,
                      "mois" => $ficheFrais['mois']);
        
        $this->SetFont('Arial', '', 14);
        $this->AddPage();
        $this->HeaderInfosPerso($info);
        $this->ElementsForfait($HEADER_FRAIS_FORFAITISES, $ficheFrais['listeFraisForfaitises']);
        $this->ElementsHorsForfait($HEADER_FRAIS_HF, $ficheFrais['listeFraisHorsForfait']);
        $this->Signature();
    }
    
    
    /**
     * Fonction permettant la création des index de numéro de page
     * @return array(int, int) l'index des numéros de pages de fiche de frais HF
     */
    function createNumPage(){
        //On saute les pages de garde et le sommaire (18 lignes par page sommaire)
        $pageArray = array();
        $countEl = sizeof($this->_ficheFraisTab);
        $countEl = floor($countEl/18);
        $nbPages = 2+$countEl;
        $i = 0;
        foreach($this->_ficheFraisTab as $key=>$unFrais){
            //S'il y a plus de lignes de frais hors-forfait que la page peut en mettre
            $countFraisHF = sizeof($unFrais['listeFraisHorsForfait']);
            $countFraisHF = 1+floor($countFraisHF);
            $nbPages = $countFraisHF;
            $pageArray[$key] = $nbPages;
        }
        return $pageArray;
    }
    
    /**
     * Crée une page de garde
     */
    function pageDeGarde(){
        $this->AddPage();
    }
    
    /**
     * Crée la table des matières pour le pdf
     * @param array (int, int) $nbPagesArray l'index des numéros de pages
     */
    function tableOfContent($nbPagesArray){
        $pageIndex = 1;
        $this->AddPage();
        $this->SetFont('Times', 'BI');
        $this->SetTextColor(31, 73, 125);
        $this->Cell(190, 6, utf8_decode('Table des matières'), 0, 0, 'C', 0);
        $this->SetFont('Times', '');
        $this->SetTextColor(0, 0, 0);
        $this->Ln();
        foreach($this->_ficheFraisTab as $key => $uneFiche){
            $pageIndex = +$nbPagesArray[$key];
            $this->Cell(170, 6, 'Fiche frais du mois '.$uneFiche['mois'], 0, 0,'L',0);
            $this->Cell(20, 6, $pageIndex.'/'.end($nbPagesArray), 0, 0,'R',0);
            
        }
    }
    
    function createPDF($ficheFraisTab, $idVisiteur, $nomComplet, $outputFileName = "../pdfOutput/ficheFrais.pdf"){
        //Chargement des données
        try{
            $this->_ficheFraisTab = $ficheFraisTab;
            $this->_idVisiteur = $idVisiteur;
            $this->_nomComplet = $nomComplet;
            $this->_fileName = $outputFileName;
            //On crée une array de numéro de page
            $nbPagesArray = $this->createNumPage();
            //On crée le sommaire
            $this->tableOfContent($nbPagesArray);
            //On ajoute chaque fiche de frais au fichier pdf
            foreach($this->_ficheFraisTab as $uneFiche){
                $this->addPageFicheFrais($uneFiche);
            }
            //On retourne le fichier pdf créé
            //$this->output($outputFileName, 'I');
        } catch (Exception $ex) {
          die("Erreur : ".$ex->getMessage());
        }
    }

    /**
     * Constructeur de la classe
     * @param type $ficheFraisTab le tableau des fiches de frais à exporter au format pdf
     * @param type $idVisiteur le matricule du visiteur
     * @param type $nomComplet le nom complet du visiteur
     * @param type $outputFileName le chemin du fichier pdf à exporter
     */
    function __construct($ficheFraisTab, $idVisiteur, $nomComplet, $outputFileName = '../pdfOutput/ficheFrais.pdf') {
        //Appel de la fonction de construction de la classe mère
        parent::__construct();
        //Chargement des données
        $this->_ficheFraisTab = $ficheFraisTab;
        $this->_idVisiteur = $idVisiteur;
        $this->_nomComplet = $nomComplet;
        //Création de la page de garde
        $this->pageDeGarde();
        //On crée une array de numéro de page
        $nbPagesArray = $this->createNumPage();
        //On crée le sommaire
        $this->tableOfContent($nbPagesArray);
        //On ajoute chaque fiche de frais au fichier pdf
        foreach($this->_ficheFraisTab as $uneFiche){
            $this->addPageFicheFrais($uneFiche);
        }
        //On retourne le fichier pdf créé
        $this->output($outputFileName, 'I');
    }
}
?>