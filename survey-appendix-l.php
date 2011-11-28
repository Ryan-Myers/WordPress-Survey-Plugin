<?php
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information

$pdf->SetCreator('Survey Plugin');
$pdf->SetAuthor('Reterborough FHT');
$pdf->SetTitle('Youth Sports Concussion Program Rehabilitation Outline');
$pdf->SetSubject('Youth Sports');
$pdf->SetKeywords('Appendix L');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// create some HTML content
$html = "<div><font color='#FF0000'>More Hello World {$_POST['user']}</font></div>";

// output the HTML content
$pdf->writeHTML($html);

// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
//$pdf->Output('Return-To-Play.pdf', 'I'); //Output to screen.
$pdf->Output(sys_get_temp_dir().'/appendix-l.pdf', 'F'); //Save file
//============================================================+
// END OF FILE                                                
//============================================================+