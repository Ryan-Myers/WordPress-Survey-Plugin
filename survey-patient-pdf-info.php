<?php
require_once('../../../wp-config.php');

//Gather user variables.
global $wpdb,$patient_name,$lastedited,$school,$birthdate;

//Grab users name
$query = "SELECT fullname FROM {$wpdb->prefix}survey_users WHERE id=%d";
$patient_name = $wpdb->get_var($wpdb->prepare($query, $_POST['user']));

//Grab the first time a question was edited, and use that as the basis for their date of visit.
$query = "SELECT lastedited FROM {$wpdb->prefix}survey_user_answers WHERE user=%d ORDER BY lastedited LIMIT 1";
$lastedited = substr($wpdb->get_var($wpdb->prepare($query, $_POST['user'])), 0, 10);

//Grab the users school.
$query = "SELECT answer FROM {$wpdb->prefix}survey_user_answers WHERE user=%d AND question=59";
$school = $wpdb->get_var($wpdb->prepare($query, $_POST['user']));

//Grab their birthdate. It's the first 3 questions as day/month/year.
$query = "SELECT answer FROM {$wpdb->prefix}survey_user_answers 
WHERE user=%d AND (question=1 OR question=2 OR question=3)";
$birthdate = implode('-',$wpdb->get_col($wpdb->prepare($query, $_POST['user'])));