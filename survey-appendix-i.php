<?php
require_once('tcpdf/tcpdf.php');
@require_once('fdpi/fpdi.php');

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
            $this->setSourceFile('AppendixI.pdf');
            $this->_tplIdx = $this->importPage(1);
        }
        $this->useTemplate($this->_tplIdx);
    }
    
    function Footer() {}
}

//Gather user variables.
global $wpdb;

$query = "SELECT fullname FROM {$wpdb->prefix}survey_users WHERE id=%d";
$patient_name = $wpdb->get_var($wpdb->prepare($query, $_POST['user']));

$query = "SELECT answer FROM {$wpdb->preix}survey_user_answers WHERE user=%d AND question=59";
$school = $wpdb->get_var($wpdb->prepare($query, $_POST['user']));

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
$pdf->writeHTMLCell(50, 1, 150, 43, "Visit");
$pdf->writeHTMLCell(50, 1, 28, 53, "School");
$pdf->writeHTMLCell(50, 1, 150, 53, "DOB");
$pdf->writeHTMLCell(50, 1, 38, 150, "Date_of_Injury");
$pdf->writeHTMLCell(50, 1, 12, 158, "x");
$pdf->writeHTMLCell(50, 1, 12, 164, "x");
$pdf->writeHTMLCell(50, 1, 75, 164, "Ret_Date");//  Return on (date
$pdf->writeHTMLCell(50, 1, 12, 171, "x");

$pdf->writeHTMLCell(50, 1, 20, 179, "x");
$pdf->writeHTMLCell(50, 1, 70, 179, "4");//Rec Hours
$pdf->writeHTMLCell(50, 1, 116, 179, "Rec_Date");//Rec Hours
$pdf->writeHTMLCell(50, 1, 20, 184, "x");
$pdf->writeHTMLCell(50, 1, 144, 184, "M1");//Minutes
$pdf->writeHTMLCell(50, 1, 20, 188, "x");
$pdf->writeHTMLCell(50, 1, 20, 193, "x");
$pdf->writeHTMLCell(50, 1, 65, 194, "M2");//percent
$pdf->writeHTMLCell(50, 1, 139, 194, "M2");//minutes.
$pdf->writeHTMLCell(50, 1, 20, 198, "x");
$pdf->writeHTMLCell(50, 1, 20, 204, "x");
$pdf->writeHTMLCell(50, 1, 20, 209, "x");
$pdf->writeHTMLCell(50, 1, 90, 218, "Rec_Date");//recommendations
$pdf->writeHTMLCell(50, 1, 12, 232, "Rec_Date");//Physician

// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
//$pdf->Output('Return-To-Play.pdf', 'I'); //Output to screen.
//$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'F'); //Save file
unlink(sys_get_temp_dir().'/appendix-i.pdf'); //Delete the temp file before recreating it.
$pdf->Output(sys_get_temp_dir().'/appendix-i.pdf', 'FI'); //Output to screen. and save to location.
//$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'FD'); //Force Download. and save to location.
//============================================================+
// END OF FILE                                                
//============================================================+