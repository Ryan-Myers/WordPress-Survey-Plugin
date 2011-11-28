<?php
@require_once('../../../wp-config.php');

//Verify that it's a physician looking to generate this form.
if (is_physician(get_survey_user_session())) {
    require "survey-appendix-{$_POST['appendix']}.php";
}