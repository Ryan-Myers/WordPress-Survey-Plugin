<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);
require_once '../../../wp-config.php';
require_once 'survey-include.php';
require_once 'survey-class.php';
require_once 'survey-question-class.php';

debug($_POST);

$question = new question(1);
$survey = new survey(2);
$survey->add_qobject($question);
debug($survey);

$survey->output_survey();

debug($survey->get_answers());
debug($survey);