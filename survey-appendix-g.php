<?php
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information

$pdf->SetCreator('Survey Plugin');
$pdf->SetAuthor('Reterborough FHT');
$pdf->SetTitle('Youth Sports Concussion Program Return to Play Clearance Form');
$pdf->SetSubject('Youth Sports');
$pdf->SetKeywords('Appendix G');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// create some HTML content
$html = '<div><font color="#FF0000">Hello World</font></div>';

// output the HTML content
$pdf->writeHTML($html);

// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
$pdf->Output('Return-To-Play.pdf', 'I');
//============================================================+
// END OF FILE                                                
//============================================================+