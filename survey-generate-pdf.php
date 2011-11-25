<?php
@require_once('../../../wp-config.php');

//Verify that it's a physician looking to generate this form.
if (is_physician(get_survey_user_session())) {
    include 'survey-appendix-'.$_POST['appendix'].'.php';
    
    echo plugins_url("survey-download-pdf.php", __FILE__);
    echo '?file=Return-To-Play.pdf';
}