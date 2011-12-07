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
<table style="width: 800px;" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td><img style="width: 800px; height: 119px;" alt=""
 src="images/apH.PNG"> </td>
    </tr>
    <tr>
      <td style="font-family: Arial;" align="left">
      <table>
        <tbody>
          <tr>
            <td> Patient Name: _____________________________________</td>
            <td> Date of Visit: _____________ </td>
          </tr>
          <tr>
            <td> <br>
School: _____________________________________ </td>
            <td> <br>
Date of Birth: _____________ </td>
          </tr>
        </tbody>
      </table>
      <br>
&nbsp;The patient above has been have been diagnosed with a concussion
and is not considered safe to return to collision sport activity until
cleared at an appropriate time by a physician or nurse practitioner.
The following text outlines current activity restrictions: <br>
      <br>
&nbsp;No physical exertion until scheduled reassessment on
_________________. <br>
      <br>
Physical exertion is permitted with the following restrictions as of
_________________: <br>
___ Light non-contact exertion.<br>
&nbsp;___ Moderate non-contact exertion. <br>
___ Heavy non-contact exertion. <br>
      <br>
Physical exertion is permitted when symptom free for _____ days with
the following restrictions as of _________________: <br>
___ Light non-contact exertion. <br>
___ Moderate non-contact exertion. <br>
___ Heavy non-contact exertion.&nbsp; <br>
      <br>
Begin Youth Sports Concussion Program Return to Play Protocol. <br>
      <br>
Signature: _____________________________________________ <br>
      <br>
ACTIVITY LEVELS <br>
Light non-contact exertion: Walking, stationary cycling, light jogging,
light resistance training <br>
Moderate non-contact exertion: Moderate jogging, stationary cycling,
elliptical, moderate resistance training <br>
Heavy non-contact exertion: Sprinting, heavy resistance training,
non-contact sport drills, plyometrics <br>
      <br>
*If development of worsening of symptoms occurs with recommended
activity levels/ restrictions then please discontinue activity for 24
hours and resume at a lighter level.</td>
    </tr>
    <tr>
      <td align="left"> &nbsp;</td>
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
$pdf->Output(sys_get_temp_dir().'/appendix-h.pdf', 'F'); //Save file
//============================================================+
// END OF FILE                                                
//============================================================+