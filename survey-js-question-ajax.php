<?php
@require_once('../../../wp-config.php');
global $wpdb;

$user_id = get_survey_user_session();

if ($user_id === FALSE) {
    die(); //Don't do anything if they aren't logged in.
}

$question_id = intval($_POST['question']);
$answer_id = intval($_POST['answer']);

$query="SELECT id,questiontype FROM {$wpdb->prefix}survey_questions WHERE dependentquestion=%d AND dependentanswer=%d";
$questions = $wpdb->get_results($wpdb->prepare($query, $question_id, $answer_id));

$collection = array();

foreach ($questions as $question) {
    switch($question->questiontype) {
        case question::truefalse:
            $pre = "tf";
        break;
        
        case question::multichoice:
            $pre = "mc";
        break;
        
        case question::dropdown:
            $pre = "dd";
        break;
        
        case question::multiselect:
            $pre = "ms";
        break;
        
        case question::shortanswer:
            $pre = "sa";
        break;
        
        case question::longanswer:
            $pre = "la";
        break;
        
        case question::multichoiceother:
            $pre = "mco";
        break;
        
        case question::multselectother:
            $pre = "mso";
        break;
        
        default:
            $pre = "";
    }
    
    $collection[] = "input[name='{$pre}-{$question->id}']";
}

echo json_encode($collection);

die();