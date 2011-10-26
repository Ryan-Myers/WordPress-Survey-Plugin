<?php
@require_once('../../../wp-config.php');

//Set up the form data in a way that's more accessible.
$form = array();
foreach($_POST['form'] as $posted) {
    //If it's an array of data, set it up that way.
    if (substr($posted['name'], -2) == '[]') {
        $form[substr($posted['name'], 0, -2)][] = $posted['value'];
    }
    else {
        $form[$posted['name']] = $posted['value'];
    }
}

$survey = new survey($form['survey-id']);

$answers = $survey->get_answers($form);

debug($_POST);
debug($form);
debug($answers);

die();//Must die to properly return the results.