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
$html = <<<HTML
<font color="#211d1e" size="+1"><font color="#939698" size="+1">
<div class="Sect">
<p class="style1"> </p>
<table style="text-align: left; width: 800px;" border="0"
 cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td style="vertical-align: top;">
      <p> <img style="width: 800px; height: 123px;" alt=""
 src="images/apL.PNG"></p>
      </td>
    </tr>
    <tr>
      <td style="vertical-align: top;"><font color="#211d1e" size="+1"><font
 color="#939698" size="+1">
      <div class="Sect">
      <p class="style1"><font color="#4c4c4e" size="+3">Rehabilitation
Outline</font></p>
      <font color="#4c4c4e" size="+3"> </font></div>
      <font color="#4c4c4e" size="+3"> </font>
      <div class="Sect"><font color="#4c4c4e" size="+3"> </font>
      <p class="style1"><font color="#4c4c4e" size="+3"> <font
 color="#211d1e" size="+1">An athlete may be referred for skilled
rehabilitation services following a concussion at the discretion of the
healthcare provider. Referrals are encouraged to be directed to a
practitioner with experience in the evaluation and management of
concussions such as a registered physiotherapist or certified athletic
trainer. The following briefly outlines components of a youth sport
concussion rehabilitation program.</font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"> </font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"> <font color="#5a9b99" size="+1"><span
 class="style2">ASSESSMENT</span></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"> </font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"> <font
 color="#211d1e" size="+1">Assessment of the athlete&acirc;&#8364;&#8482;s
concussion shall
be under the discretion of the rehabilitation provider, but may include
the following:</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Past medical history</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1">Mechanism of injury</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Current medical/concussion history</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Neurological-musculoskeletal physical
assessment</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> SCAT2</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> BESS balance testing</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Additional injury identification,
including cervical screen, TMJ screen, vertigo (BPPV)</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Continued clinical assessment of signs
and symptoms provided by referral source </font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Outcome measures (Neck Disability Index,
Headache, TMJ)</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Referral to a primary care provider such as
a family physician or nurse practitioner, or a specialist where
necessary, should be provided for any of the following
&acirc;&#8364;&#732;Red/Yellow
Flag&acirc;&#8364;&#8482; signs or symptoms:</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Suspicion of cranial or cervical fracture</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Upper cervical instability</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Cord signs or symptoms</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Upper motor neuron signs or symptoms</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Cerebellar signs</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Vertebral artery signs or symptoms</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Cranial nerve deficit</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Deterioration in condition</font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> <font color="#5a9b99" size="+1">REHABILITATION
PLAN </font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"> </font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"> <font
 color="#211d1e" size="+1">It is encouraged that a Rehabilitation Plan
is established that highlights relevant clinical findings, creates a
problem list, and develops a treatment plan with long and short term
goals for recovery. The Rehabilitation Plan should include:</font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1">Clinical assessment and treatment
recommendations</font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1">Education pertaining to concussions,
rehabilitation program philosophy, concussion management, goals and
recovery expectations, and return to play protocol.</font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Continued education regarding rest,
physical and cognitive activity avoidance, and recommendations for
adjustment of academic course work and physical activity.</font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> Best practice guidelines for management
of clinical findings related to concussion, as well as associated
injury including cervical, TMJ, vertigo, etc.</font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> The rehabilitation course will be
documented.</font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> <font color="#5a9b99" size="+1">RETURN TO
PLAY</font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"> </font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"> <font
 color="#211d1e" size="+1">Once the athlete is asymptomatic at rest and
repeat computer based neuropsychological testing is confirmed to be at
baseline, it is recommended that the Return to Play Protocol be
initiated. See Appendix J. </font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> <font color="#5a9b99" size="+1">RETURN TO
SPORT</font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"> </font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"> <font
 color="#211d1e" size="+1">Once the return to play clearance per the
treating healthcare provider has be confirmed a return to sport may be
initiated. Ideally, an athlete may be monitored through this phase of
recovery as well, with monitoring potentially provided by the
healthcare provider, rehabilitation provider, trainer, coach, and/or
parent. Prior to return to sport it is recommended that the
athletes&acirc;&#8364;&#8482;
equipment be examined to ensure adequate protection. </font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> It is encouraged that a post return to
sport assessment be conducted by the rehabilitation provider. This
should occur within 2-3 weeks following Return to Sport. This
reassessment should include review of prior concussion-related signs
and symptoms to ensure resolution. </font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"> <font color="#5a9b99" size="+1">FOLLOW UP
AND OUTCOME MEASUREMENT</font></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"> </font></font></font></font></font></font></font></font></font></font></font>
      <p class="style1"><font color="#4c4c4e" size="+3"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"><font
 color="#211d1e" size="+1"><font color="#5a9b99" size="+1"> <font
 color="#211d1e" size="+1">A 3 month follow up is also recommended by
phone, by the rehabilitation provider. Outcome measures, satisfaction
surveys, and other relevant research/statistical information may be
collected at this time as well.</font></font></font></font></font></font></font></font></font></font></font></font></p>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font></font></font></font></font></font></font></div>
      <font color="#4c4c4e" size="+3"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"><font
 color="#5a9b99" size="+1"><font color="#211d1e" size="+1"> </font></font></font></font></font></font></font></font></font></font></font>
      </font></font></font>
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
$pdf->Output(sys_get_temp_dir().'/appendix-l.pdf', 'F'); //Save file
//============================================================+
// END OF FILE                                                
//============================================================+