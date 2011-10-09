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
    `hidden` BOOLEAN NOT NULL DEFAULT  '0')");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_answers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `question` INT NOT NULL ,
    `answer` TEXT NULL DEFAULT NULL ,
    `hidden` BOOLEAN NOT NULL DEFAULT  '0')");
    
    //Add the survey version to the wordpress options table. 
    //Useful for making sure they're on the latest version, and for adding proper upgrade paths.
    add_option('survey_version', $survey_version);
}

/*** This get's called upon deactivation ***/
function survey_deactivation() {
    global $wpdb;
	
    //Remove the created tables for this plugin
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey");
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_questions");
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_answers");
    
    //Remove the survey version from the wordpress options table.
    //delete_option('survey_version');
}

/*** Allows a shortcode to be created that will add the survey to the page. The shortcode is [survey-page] ***/
add_shortcode('survey-page','survey_page');
function survey_page($atts, $content=null) {
    debug($_POST);

    $question = new question(1);
    $survey = new survey(2);
    $survey->add_qobject($question);

    $survey->output_survey();

    debug($survey->get_answers());
    debug($survey);
}

/*** Adds the survey-style CSS file to the header ***/
add_action('wp_print_styles', 'survey_css');
function survey_css() {
    wp_register_style("survey_style_css", plugins_url('survey-style.css', __FILE__));
	wp_enqueue_style("survey_style_css");
}