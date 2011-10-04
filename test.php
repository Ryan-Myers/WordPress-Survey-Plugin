<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);
require_once '../../../wp-config.php';
require_once 'survey-include.php';
require_once 'survey-class.php';
require_once 'survey-question-class.php';

debug($_POST);

echo '<form method="post" action="'.$_SERVER['PHP_SELF'].'">';
$question = new question(12);
//debug($question);

echo "<b>Testing true/false</b><br />\n";
$question->questiontype = question::truefalse;
$question->output_question();
debug($question->get_answer());

echo "<b>Testing multiple choice</b><br />\n";
$question->questiontype = question::multichoice;
$question->output_question();
debug($question->get_answer());

echo "<b>Testing dropdown</b><br />\n";
$question->questiontype = question::dropdown;
$question->output_question();
debug($question->get_answer());

echo "<b>Testing multiple selection</b><br />\n";
$question->questiontype = question::multiselect;
$question->output_question();
debug($question->get_answer());

echo '<input type="submit" /> </form>';

$survey = new survey(2);
//$survey->add_qobject($question);
debug($survey);