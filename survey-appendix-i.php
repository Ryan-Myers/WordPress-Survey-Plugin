<?php
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information

$pdf->SetCreator('Survey Plugin');
$pdf->SetAuthor('Reterborough FHT');
$pdf->SetTitle('Youth Sports Concussion Program Return to School Recommendations');
$pdf->SetSubject('Youth Sports');
$pdf->SetKeywords('Appendix I');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// create some HTML content
$html = <<<HTML
<font color="#211d1e" size="+1"><font color="#939698" size="+1">
<div class="Sect">
<p class="style1"> </p>
<table style="text-align: left; width: 800px;" border="1"
 cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="vertical-align: top;">
      <p> <img style="width: 800px; height: 120px;" alt=""
 src="images/apI.PNG"></p>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1">
      <div class="Sect">
      <p class="style1"><font color="#4c4c4e" size="+3">Return to
School Recommendations</font></p>
      <font color="#4c4c4e" size="+3"> </font></div>
      <font color="#4c4c4e" size="+3"> </font>
      <div class="Sect"><font color="#4c4c4e" size="+3"> </font>
      <p class="style1"><font color="#4c4c4e" size="+3"> <font
 color="#211d1e" size="+1">Patient Name:
_____________________________________ Date of Visit: _____________</font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"> School:
_____________________________________ Date of Birth: _____________</font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"> In the early stages of recovery after a
concussion, increased cognitive demands, such as playing video games,
listening to loud music, excess physical activity, and academic
coursework may worsen symptoms and prolong recovery. Accordingly, a
comprehensive concussion management plan will provide appropriate
provisions for adjustment of academic coursework on a case by case base.</font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"> The following provides a framework of
possible recommendations that may be made by the treating healthcare
provider:</font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"> 1. Inform the teacher(s) and
administrator(s) about your injury and symptoms. School personnel
should be instructed to watch for:</font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font>
      <p><font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1">
      <font color="#626365">•<font color="#211d1e"><span class="style1">
Increased problems with paying attention, concentrating, remembering,
or learning new information </span> <font color="#626365"><span
 class="style1">• </span> <font color="#211d1e"> <span class="style1">Longer
time needed to complete tasks or assignments </span> <font
 color="#626365"><span class="style1">• </span> <font color="#211d1e">
      <span class="style1">Greater irritability, less able to cope with
stress </span> <font color="#626365">•<font color="#211d1e"><span
 class="style1"> Symptoms worsen (e.g. headache, tiredness) when doing
schoolwork</span></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"> </font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"> Until the
student has recovered, the following supports are recommended and this
information should be shared with the school Guidence Department:
(check all that apply)</font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"> </font></font></font></font></font></font></font></font></font></font>
      <ul>
        <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e">
        <li>
          <p class="style1"> Date of Injury: _____________</p>
        </li>
        <li><font color="#211d1e" size="+1"><span class="style1">May
return immediately to school full days.</span></font></li>
        <font color="#211d1e" size="+1">
        <li><font color="#211d1e"><span class="style1">No return to
school. Return on (date) _________________________.</span></font></li>
        <font color="#211d1e">
        <li><font color="#211d1e"><span class="style1">Return to school
with supports as checked below. </span></font></li>
        <font color="#211d1e">
        <li><font color="#211d1e"><span class="style1">Shortened day.
Recommend __ hours per day until (date) _________________________.</span><font
 size="+1"> <font color="#5a9b99">q<font color="#211d1e"><span
 class="style1"> Shortened classes (i.e. rest breaks during classes).
Maximum class length: ______ minutes. </span><font color="#5a9b99">q<font
 color="#211d1e"><span class="style1"> Allow extra time to complete
coursework/assignments and tests. </span><font color="#5a9b99">q<font
 color="#211d1e"><span class="style1"> Lessen homework load by __%.
Maximum length of nightly homework: ______ minutes. </span><font
 color="#5a9b99"><span class="style1">q </span> <font color="#211d1e"><span
 class="style1">No significant classroom or standardized testing at
this time. </span><font color="#5a9b99">q<font color="#211d1e"><span
 class="style1"> No more than one test per day. </span><font
 color="#5a9b99">q<font color="#211d1e"><span class="style1"> Take rest
breaks during the day as needed.</span></font></font></font></font></font></font></font></font></font></font></font></font></font></font></li>
        <font color="#211d1e"><font size="+1"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"> </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font>
      </ul>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#211d1e" size="+1"><font
 color="#211d1e"><font color="#211d1e"><font color="#211d1e"><font
 size="+1"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"> </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#211d1e" size="+1"><font color="#211d1e"><font color="#211d1e"><font
 color="#211d1e"><font size="+1"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"> Review above recommendations on
(date) _____________</font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#211d1e" size="+1"><font
 color="#211d1e"><font color="#211d1e"><font color="#211d1e"><font
 size="+1"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"> </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font>
      <p><font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#211d1e" size="+1"><font
 color="#211d1e"><font color="#211d1e"><font color="#211d1e"><font
 size="+1"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"> <span class="style1">___________________________________________
___________________________________________ </span><span class="style2"><br>
Name of Health Care Provider</span> <span class="style2">Signature</span></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#211d1e" size="+1"><font
 color="#211d1e"><font color="#211d1e"><font color="#211d1e"><font
 size="+1"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"> </font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></font></div>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#626365"><font color="#211d1e"><font color="#626365"><font
 color="#211d1e"><font color="#626365"><font color="#211d1e"><font
 color="#626365"><font color="#211d1e"><font color="#211d1e" size="+1"><font
 color="#211d1e"><font color="#211d1e"><font color="#211d1e"><font
 size="+1"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"><font color="#5a9b99"><font color="#211d1e"><font
 color="#5a9b99"><font color="#211d1e"><font color="#5a9b99"><font
 color="#211d1e"> </font></font></font></font></font></font></font></font></font></font></font>
      </font></font></font></font></font></font></font> </font></font></font></font></font></font></font></font></font></font>
      </font>
      <p class="style1">&nbsp; <br>
      </p>
      </td>
    </tr>
  </tbody>
</table>
<p class="style1"><font color="#4c4c4e" size="+3"><br>
<br>
</font></p>
</div>
</font></font>
HTML;

// output the HTML content
$pdf->writeHTML($html);

// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('Return-To-Play.pdf', 'D'); // Force Download
//$pdf->Output('Return-To-Play.pdf', 'I'); //Output to screen.
$pdf->Output(sys_get_temp_dir().'/appendix-i.pdf', 'F'); //Save file
//============================================================+
// END OF FILE                                                
//============================================================+