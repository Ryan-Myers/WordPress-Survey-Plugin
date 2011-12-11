<?php
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information

$pdf->SetCreator('Survey Plugin');
$pdf->SetAuthor('Reterborough FHT');
$pdf->SetTitle('Youth Sports Concussion Program Post-Injury General Information and Exertion Form');
$pdf->SetSubject('Youth Sports');
$pdf->SetKeywords('Appendix H');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// create some HTML content
$html = <<<HTML
<center>
<table cellpadding="0" cellspacing="0">
    <tbody>
        <tr><td><img alt="Appendix H" src="images/apH.PNG"></td></tr>
        <tr>
        <td align="left">
            <table>
                <tbody>
                    <tr>
                        <td>Patient Name: __________________________</td>
                        <td>Date of Visit: _______</td>
                    </tr>
                    <tr>
                        <td>School: _____________</td>
                        <td>Date of Birth: _____________</td>
                    </tr>
                </tbody>
            </table>
            <br>
            The patient above has been have been diagnosed with a concussion
            and is not considered safe to return to collision sport activity until
            cleared at an appropriate time by a physician or nurse practitioner.
            The following text outlines current activity restrictions: <br>
            <br>
            No physical exertion until scheduled reassessment on _________________. <br>
            <br>
            Physical exertion is permitted with the following restrictions as of _________________:<br>
            <br>
            ___ Light non-contact exertion.<br>
            ___ Moderate non-contact exertion. <br>
            ___ Heavy non-contact exertion. <br>
            <br>
            <br>
            Physical exertion is permitted when symptom free for _____ days <br>
            with the following restrictions as of _________________: <br>
            <br>
            ___ Light non-contact exertion. <br>
            ___ Moderate non-contact exertion. <br>
            ___ Heavy non-contact exertion <br>
            <br>
            Begin Youth Sports Concussion Program Return to Play Protocol. <br>
            <br>
            Signature: _____________________________________________ <br>
            <br>
            ACTIVITY LEVELS <br>
            Light non-contact exertion: Walking, stationary cycling, light jogging, light resistance training <br>
            Moderate non-contact exertion: Moderate jogging, stationary cycling, elliptical, 
            moderate resistance training <br>
            Heavy non-contact exertion: Sprinting, heavy resistance training, non-contact sport drills, plyometrics <br>
            <br>
            *If development of worsening of symptoms occurs with recommended activity levels/ restrictions then 
            please discontinue activity for 24 hours and resume at a lighter level.
        </td>
    </tr>
  </tbody>
</table>
</center>
HTML;

// output the HTML content
$pdf->writeHTML($html);

// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
//$pdf->Output('Return-To-Play.pdf', 'I'); //Output to screen.
//$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'F'); //Save file
$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'FI'); //Output to screen. and save to location.
//$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'FD'); //Force Download. and save to location.
//============================================================+
// END OF FILE                                                
//============================================================+