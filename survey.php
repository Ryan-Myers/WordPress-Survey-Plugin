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
require_once 'survey-class.php';
require_once 'survey-question-class.php';
require_once 'survey-js.php';

register_activation_hook(__FILE__, 'survey_activation');
register_deactivation_hook(__FILE__, 'survey_deactivation');
add_action('wp_ajax_surveys_ajax', 'survey_surveys_ajax_callback');
add_action('wp_ajax_survey_select_ajax', 'survey_select_ajax_callback');
add_action('wp_ajax_survey_add_question_ajax', 'survey_add_question_ajax_callback');
add_action('wp_ajax_survey_submit_question_ajax', 'survey_submit_question_ajax_callback');
add_action('wp_ajax_survey_create_ajax', 'survey_create_ajax_callback');
add_action('wp_ajax_survey_edit_ajax', 'survey_edit_ajax_callback');
add_action('wp_ajax_survey_delete_ajax', 'survey_delete_ajax_callback');
add_action('wp_ajax_survey_question_delete_ajax', 'survey_question_delete_ajax_callback');

/**
    Upon Activating the plugin this gets called. It will set the tables and options.
**/
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

/**
    This get's called upon deactivation of the plugin. This will cleanup the tables and options created.
**/
function survey_deactivation() {
    global $wpdb;
	
    //Remove the created tables for this plugin
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey");
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_questions");
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_answers");
    
    //Remove the survey version from the wordpress options table.
    delete_option('survey_version');
}

/**
    Allows a shortcode to be created that will add the survey to the page. The shortcode is [survey-page id=123] 
**/
add_shortcode('survey-page','survey_page');
function survey_page($atts, $content=null) {
    $survey = new survey($atts['id']);
    
    for ($i = 1; $i <= $survey->pages; $i++) {
        echo $survey->output_survey($i);
    }
}

/**
    Allows a shortcode to be created that will create a test survey with sample data. Debug use only!
**/
add_shortcode('survey-test','survey_test');
function survey_test($atts, $content=null) {
    debug($_POST);
    
    $survey1 = new survey(FALSE, "Survey 1");
    
    $question1 = $survey1->add_question(question::truefalse, "True/False: Order 1", 1);
    $question1->add_answer("TF Answer 1 DONT SHOW THIS!", 1);
    
    $question2 = $survey1->add_question(question::multichoice, "Multiple Choice: Order 2", 2);
    $question2->add_answer("MC Answer 1", 1);
    $question2->add_answer("MC Answer 2");
    $question2->add_answer("MC Answer 3", 3);
    
    $question3 = $survey1->add_question(question::dropdown, "Dropdown: Order 3", 3);
    $question3->add_answer("DD Answer 1");
    $question3->add_answer("DD Answer 2", 2);
    
    $question4 = $survey1->add_question(question::multiselect, "Multiple Select: Order 4", 1);
    $question4->add_answer("MS Answer 2", 2);
    $question4->add_answer("MS Answer 1", 1);
    $question4->add_answer("MS Answer 3", 3);
    
    $question5 = $survey1->add_question(question::shortanswer, "Short Answer: Order 6", 6);
    $question5->add_answer("SA Answer 1 DONT SHOW THIS!", 1);
    
    $question6 = $survey1->add_question(question::longanswer, "Long Answer: Order 5", 5);
    $question6->add_answer("LA Answer 1 DONT SHOW THIS!", 1);
    
    $question7 = $survey1->add_question(question::multichoiceother, "Multiple Choice Other: Order 7", 7);
    $question7->add_answer("MCO Answer 1");
    $question7->add_answer("MCO Answer 2");
    
    $question8 = new question(FALSE, question::multiselectother, "Multiple Select Other: Order 8", 8);
    $question8->add_answer("MSO Answer 1");
    $question8->add_answer("MSO Answer 2");
    $survey1->add_qobject($question8);
    
    $survey1->output_survey();
    debug($survey1);
    
    if (isset($_POST['survey-id'])) {
        $surveyOLD = new survey($_POST['survey-id']);
        debug($surveyOLD->get_answers());
        debug($surveyOLD);
    }
}

/**
    Adds the survey-style CSS file to the header 
**/
add_action('wp_print_styles', 'survey_css');
function survey_css() {
    wp_register_style("survey_style_css", plugins_url('survey-style.css', __FILE__));
	wp_enqueue_style("survey_style_css");
}

/**
    Adds an option page for configuring the surveys. 
**/
add_action('admin_menu', 'survey_add_admin_link');
function survey_add_admin_link() {
    $plugin_page = add_options_page('Survey Configuration', 'Survey Configuration', 'manage_options', 
                     'SurveyOptionsPage', 'survey_show_admin_page');
    
    //Add the javascript
    add_action( "admin_head-{$plugin_page}", 'survey_admin_js');
}

/**
    Quick and dirty variable output.
**/
function debug($var) {
    echo '<pre>'.print_r($var, true)."</pre>\n";
}