<?php
/*
Plugin Name: Survey
Plugin URI: http://ryanmyers.ca
Description: Creates a survey for patients of PeterboroughFHT
Version: 1.0
Author: Ryan Myers
Author URI: http://ryanmyers.ca
*/

global $survey_salt;
$survey_salt = '92e0d8723fa997f83edd4f2df260844db24847e6';

require_once 'survey-admin.php';
require_once 'survey-class.php';
require_once 'survey-question-class.php';
require_once 'survey-js-admin.php';
require_once 'survey-registration.php';
require_once 'survey-page.php';

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
add_action('wp_ajax_survey_add_dependency_ajax', 'survey_add_dependency_ajax_callback');

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
    `questionsperpage` INT NOT NULL DEFAULT  '3')");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_questions` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `question` TEXT NULL DEFAULT NULL ,
    `questiontype` TINYINT UNSIGNED NULL DEFAULT NULL ,
    `ordernum` SMALLINT NOT NULL ,
    `dependentquestion` INT NOT NULL DEFAULT  '-1' ,
    `dependentanswer` INT NOT NULL DEFAULT  '-1' ,
    `hidden` BOOLEAN NOT NULL DEFAULT  '0')");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_answers` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `question` INT NOT NULL ,
    `answer` TEXT NULL DEFAULT NULL ,
    `ordernum` SMALLINT NOT NULL ,
    `hidden` BOOLEAN NOT NULL DEFAULT  '0')");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_users` (
    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    `username` VARCHAR( 30 ) NOT NULL ,
    `password` BINARY( 20 ) NOT NULL ,
    `fullname` VARCHAR( 50 ) NOT NULL ,
    `physician` INT NOT NULL DEFAULT '0' ,
    `is_physician` BOOLEAN NOT NULL DEFAULT  '0' ,
    `logged_in` DATETIME NULL ,
    UNIQUE (`username`))");
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "survey_user_answers` (
    `user` INT NOT NULL ,
    `question` INT NOT NULL ,
    `answer` TEXT,
    `lastedited` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (  `user` ,  `question` ))");
    
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
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey");
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_questions");
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_answers");
    //$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_users");
    $wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."survey_user_answers");
    
    //Remove the survey version from the wordpress options table.
    delete_option('survey_version');
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
    Adds the survey-js javascript file to the header.
**/
add_action('wp_enqueue_scripts', 'survey_add_script');
function survey_add_script() {
    wp_enqueue_script("jquery");
    wp_register_script("survey_script_js", plugins_url('survey-js.php', __FILE__));
    wp_enqueue_script("survey_script_js");
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
    Adds an option page for configuring the surveys. 
**/
add_action('admin_menu', 'survey_register_physician_link');
function survey_register_physician_link() {
    add_options_page('Register Physician', 'Register Physician', 'manage_options', 
                     'SurveyPhysiciansPage', 'survey_register_physician_page');
}

/**
    Quick and dirty variable output.
**/
function debug($var) {
    echo '<pre>'.print_r($var, true)."</pre>\n";
}
