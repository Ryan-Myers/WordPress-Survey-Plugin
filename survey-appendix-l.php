<?php
require_once('tcpdf/tcpdf.php');
@require_once('fdpi/fpdi.php');
//Call the basic info and set them as globals to be used below.
require_once('survey-patient-pdf-info.php');
global $patient_name,$lastedited,$school,$birthdate;

class PDF extends FPDI {
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;
    
    /**
     * include a background template for every page
     */
    function Header() {
        if (is_null($this->_tplIdx)) {
            $this->setSourceFile('AppendixL.pdf');
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx);
    }
    
    function Footer() {}
}

// initiate PDF
$pdf = new PDF();
$pdf->SetMargins(40, 48, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(true, 40);
$pdf->setFontSubsetting(false);

// add a page
$pdf->AddPage();

// now write some text onto the imported page
//Documentation for WriteHTML Cell can be found here:
//http://www.tcpdf.org/doc/classTCPDF.html#a8458280d15b73d3baffb28eebe2d9246

//The gist of it is this though: (width of cell, line height, top left x co-ordinate, tl Y co-ord, string to oputput)
$pdf->writeHTMLCell(50, 1, 38, 43, $patient_name);
$pdf->writeHTMLCell(50, 1, 150, 43, $lastedited);
$pdf->writeHTMLCell(50, 1, 28, 53, $school);
$pdf->writeHTMLCell(50, 1, 150, 53, $birthdate);

// ---------------------------------------------------------
//Close and output PDF document
unlink(sys_get_temp_dir().'/appendix-l.pdf'); //Delete the temp file before recreating it.
$pdf->Output(sys_get_temp_dir().'/appendix-l.pdf', 'FI'); //Output to screen. and save to location.

//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
//$pdf->Output('Return-To-Play.pdf', 'I'); //Output to screen.
//$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'F'); //Save file
//$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'FD'); //Force Download. and save to location.
//============================================================+
// END OF FILE                                                
//============================================================+