<?php
@require_once('../../../wp-config.php');
global $wpdb;

$user_id = get_survey_user_session();

if ($user_id === FALSE) {
    die(); //Don't do anything if they aren't logged in.
}

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

//Save each answer into the database.
foreach ($answers as $question_id=>$answer) {
    //Answers can be an array, so just seperate the answers by a two semi-colons and space if they are.
    if (is_array($answer)) $answer = implode(';; ', $answer);
    
    $query = "SELECT answer FROM {$wpdb->prefix}survey_user_answers WHERE user=%d AND question=%d";
    $prepared = $wpdb->prepare($query, $user_id, $question_id);
    $answered = $wpdb->get_row($prepared);
    
    if ($answered === NULL) {
        $wpdb->insert($wpdb->prefix."survey_user_answers", 
                      array('user'=>$user_id, 'question'=>$question_id, 'answer'=>$answer), array('%d', '%d', '%s'));
    }
    elseif($answered !== NULL && $answer != $answered->answer) {
        $wpdb->update($wpdb->prefix."survey_user_answers", 
                      array('answer'=>$answer), array('user'=>$user_id, 'question'=>$question_id), 
                      array('%s'), array('%d', '%d', '%s'));
    }
}

die();//Must die to properly return the results.