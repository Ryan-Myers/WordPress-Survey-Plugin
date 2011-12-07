<?php
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information

$pdf->SetCreator('Survey Plugin');
$pdf->SetAuthor('Reterborough FHT');
$pdf->SetTitle('Youth Sports Concussion Program Return to Play Clearance Form');
$pdf->SetSubject('Youth Sports');
$pdf->SetKeywords('Appendix K');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// create some HTML content
$html = <<<HTML
<font color="#211d1e" size="+1"><font color="#939698" size="+1"> </font></font>
<div class="Sect"><font color="#211d1e" size="+1"><font color="#939698"
 size="+1"> </font></font>
<p class="style1"><font color="#211d1e" size="+1"><font color="#939698"
 size="+1"> </font></font></p>
<table style="text-align: left; width: 800px;" border="1"
 cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="vertical-align: top;">
      <p> <img style="width: 800px; height: 122px;" alt=""
 src="images/apK.PNG"></p>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;">
      <p class="style1"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3">Return to
Play Clearance Form</font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"> </font></font></font>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"> </font></font></font>
      <div class="Sect"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3"> </font></font></font>
      <p class="style1"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3"> <font
 color="#211d1e" size="+1">Patient Name:
_____________________________________ Date of Visit: _____________</font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"> School:
_____________________________________ Date of Birth: _____________</font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p><font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> <span
 class="style1">This Athlete</span><font color="#7a2984"><span
 class="style1"> did not</span><font color="#5a9b99"> <font
 color="#211d1e"> <span class="style1">sustain a concussion and may
return to full activity.</span></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"> </font></font></font></font></font></font></font>
      <p><font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"> <span
 class="style1">This Athlete </span> <font color="#7a2984"> <span
 class="style1">was </span> <font color="#211d1e"><span class="style1">diagnosed
with a concussion and is permitted to return to </span> <font
 size="+1"> <span class="style1">full contact sports activities as of:</span></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#7a2984"><font color="#5a9b99"><font
 color="#211d1e"><font color="#7a2984"><font color="#211d1e"><font
 size="+1"> Today</font></font></font></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#7a2984"><font color="#5a9b99"><font
 color="#211d1e"><font color="#7a2984"><font color="#211d1e"><font
 size="+1"> ____________</font></font></font></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#7a2984"><font color="#5a9b99"><font
 color="#211d1e"><font color="#7a2984"><font color="#211d1e"><font
 size="+1"> Upon completion of the Youth Sports Concussion Program
Return to Play Protocol </font></font></font></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p><font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> <span
 class="style1">______________________________________
________________________________ </span><span class="style2">Name of
Health Care Provider</span> <span class="style2">Signature</span></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p><font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> <span
 class="style1">______________________________________ </span> <span
 class="style2">Date </span> </font></font></font></font></font></font></font></font></font></font></p>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font></font></font></font></font></font></font></font></font></font></div>
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"><font size="+1"> </font> </font></font></font></font></font></font></font></font></font>
      <p class="style1">&nbsp;
      <font color="#211d1e" size="+1"><font color="#939698" size="+1"><font
 color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#7a2984"><font color="#5a9b99"><font color="#211d1e"><font
 color="#7a2984"><font color="#211d1e"> <br>
      </font></font></font></font></font></font></font></font></font></p>
      </td>
    </tr>
  </tbody>
</table>
<p class="style1"><font color="#211d1e" size="+1"><font color="#939698"
 size="+1"><font color="#4c4c4e" size="+3"><br>
<br>
</font></font></font></p>
</div>
HTML;

// output the HTML content
$pdf->writeHTML($html);

// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
//$pdf->Output('Return-To-Play.pdf', 'I'); //Output to screen.
$pdf->Output(sys_get_temp_dir().'/appendix-k.pdf', 'F'); //Save file
//============================================================+
// END OF FILE                                                
//============================================================+