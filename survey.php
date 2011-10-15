<?php
/*
Plugin Name: Survey
Plugin URI: http://ryanmyers.ca
Description: Creates a survey for patients of PeterboroughFHT
Version: 1.0
Author: Ryan Myers
Author URI: http://ryanmyers.ca
*/

require_once 'survey-admin.php';
require_once 'survey-include.php';
require_once 'survey-class.php';
require_once 'survey-question-class.php';

register_activation_hook(__FILE__, 'survey_activation');
register_deactivation_hook(__FILE__, 'survey_deactivation');
add_action('admin_menu', 'survey_add_admin_link');

/*** Upon Activating the plugin this gets called. ***/
function survey_activation() {
    global $wpdb;
    $survey_version = '1.0';
    
    //Create all of the tables needed to get things up and running.
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `name` VARCHAR( 200 ) NULL DEFAULT NULL ,
    `questions` TEXT NULL DEFAULT NULL ,
    `questionsperpage` INT NOT NULL DEFAULT  '10')");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_questions` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `question` TEXT NULL DEFAULT NULL ,
    `questiontype` TINYINT UNSIGNED NULL DEFAULT NULL ,
    `ordernum` SMALLINT NOT NULL ,
    `hidden` BOOLEAN NOT NULL DEFAULT  '0')");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_answers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `question` INT NOT NULL ,
    `answer` TEXT NULL DEFAULT NULL ,
    `ordernum` SMALLINT NOT NULL ,
    `hidden` BOOLEAN NOT NULL DEFAULT  '0')");
    
    //Add the survey version to the wordpress options table. 
    //Useful for making sure they're on the latest version, and for adding proper upgrade paths.
    add_option('survey_version', $survey_version);
}

/*** This get's called upon deactivation ***/
function survey_deactivation() {
    global $wpdb;
	
    //Remove the created tables for this plugin
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey");
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_questions");
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_answers");
    
    //Remove the survey version from the wordpress options table.
    delete_option('survey_version');
}

/*** Allows a shortcode to be created that will add the survey to the page. The shortcode is [survey-page] ***/
add_shortcode('survey-page','survey_page');
function survey_page($atts, $content=null) {
    debug($_POST);
    
    $survey1 = new survey(FALSE, "Survey 1");
    
    $question1 = new question(FALSE, question::truefalse, "True/False: Order 1", 1);
    $question1->add_answer("TF Answer 1 DONT SHOW THIS!", 1);
    $survey1->add_qobject($question1);
    
    $question2 = $survey1->add_question(question::multichoice, "Multiple Choice: Order 2", 2);
    $question2->add_answer("MC Answer 1", 1);
    $question2->add_answer("MC Answer 2");
    $question2->add_answer("MC Answer 3", 3);
    
    $question3 = new question(FALSE, question::dropdown, "Dropdown: Order 3", 3);
    $question3->add_answer("DD Answer 1");
    $question3->add_answer("DD Answer 2", 2);
    $survey1->add_qobject($question3);
    
    $question4 = new question(FALSE, question::multiselect, "Multiple Select: Order 4", 4);
    $question4->add_answer("MS Answer 1", 1);
    $question4->add_answer("MS Answer 2", 2);
    $survey1->add_qobject($question4);
    
    $question5 = new question(FALSE, question::shortanswer, "Short Answer: Order 5", 5);
    $question5->add_answer("SA Answer 1 DONT SHOW THIS!", 1);
    $survey1->add_qobject($question5);
    
    $question6 = new question(FALSE, question::longanswer, "Long Answer: Order 6", 6);
    $question6->add_answer("LA Answer 1 DONT SHOW THIS!", 1);
    $survey1->add_qobject($question6);
    
    $question7 = new question(FALSE, question::multichoiceother, "Multiple Choice Other: Order 7", 7);
    $question7->add_answer("MCO Answer 1", 1);
    $question7->add_answer("MCO Answer 2", 2);
    $survey1->add_qobject($question7);
    
    $question8 = new question(FALSE, question::multiselectother, "Multiple Select Other: Order 8", 8);
    $question8->add_answer("MSO Answer 1", 1);
    $question8->add_answer("MSO Answer 2", 2);
    $survey1->add_qobject($question8);
    
    $survey1->output_survey();
    debug($survey1);
    
    $surveyOLD = new survey($_POST['survey-id']);
    debug($surveyOLD->get_answers());
    debug($surveyOLD);
    
    //$question = new question(13);
    //$survey = new survey(2);
    //$survey->add_qobject($question);

    //$survey->output_survey();

    //debug($survey->get_answers());
    //debug($survey);
}

/*** Adds the survey-style CSS file to the header ***/
add_action('wp_print_styles', 'survey_css');
function survey_css() {
    wp_register_style("survey_style_css", plugins_url('survey-style.css', __FILE__));
	wp_enqueue_style("survey_style_css");
}