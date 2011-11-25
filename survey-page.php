<?php
/**
    Allows a shortcode to be created that will add the survey to the page. The shortcode is [survey-page id=123] 
**/
add_shortcode('survey-page','survey_page');
function survey_page($atts, $content=null) {
    global $wpdb;
    
    $user_id = get_survey_user_session();
    
    if ($user_id !== FALSE) {
        //Grab the users name so we can display it later.
        $prepared = $wpdb->prepare("SELECT fullname FROM {$wpdb->prefix}survey_users WHERE id=%d", $user_id);
        $fullname = $wpdb->get_var($prepared);
        
        //Create the logout string depending on the URL type.
        $logout = (strstr($_SERVER['REQUEST_URI'], '?') === FALSE) ? "?logout=1" : "&logout=1";
    }
    
    if (is_physician($user_id)) {
        echo "<h3>Physician Logged in</h3>";
        
        echo "<div id='survey-logout'>
                You are currently logged in as $fullname, 
                <a href='{$_SERVER['REQUEST_URI']}{$logout}'>click here to logout</a>
              </div>";
              
        echo "<div>Select a patient from the list to view their survey</div>";
        
        echo "<form action='{$_SERVER['REQUEST_URI']}' method='post'>
                <select name='survey_patient'>".get_patients($user_id)."</select>
                <input type='submit' value='View Patient Survey' />
              </form>";
              
        echo "<div>Generate a PDF</div>
              <div>
                <input type='button' value='Appendix H' onclick='appendix_h($user_id)' />
                <input type='button' value='Appendix I' onclick='appendix_i($user_id)' />
                <input type='button' value='Appendix K' onclick='appendix_k($user_id)' />
                <input type='button' value='Appendix L' onclick='appendix_l($user_id)' />
              </div>";
    }
    elseif ($user_id !== FALSE) {
        $survey = new survey($atts['id']);
        
        echo "<h3>$survey->name</h3>\n";
        echo "<div id='survey-logout'>
                You are currently logged in as $fullname, 
                <a href='{$_SERVER['REQUEST_URI']}{$logout}'>click here to logout</a>
              </div>";
            
        for ($i = 1; $i <= $survey->pages; $i++) {
            echo $survey->output_survey($i);
        }
    }
    else {
        survey_registration(NULL);
    }
}

/**
    Allows a shortcode to be created that will create a test survey with sample data. Debug use only!
**/
add_shortcode('survey-test','survey_test');
function survey_test($atts, $content=null) {
    global $wpdb;
    global $survey_salt;
    
    $insert = $wpdb->insert($wpdb->prefix.'survey_users', 
                            array('username'=>'tester', 'password'=>sha1('tester'.$survey_salt, true), 
                                  'fullname'=>'Test User', 'physician'=>1), 
                            array('%s', '%s', '%s', '%d'));
                            
    $id = $insert ? $wpdb->insert_id : FALSE;
    
    if ($id !== FALSE) {
        var_dump(bin2hex(sha1('tester'.$survey_salt, true)));
        var_dump(bin2hex($wpdb->get_var("SELECT password FROM {$wpdb->prefix}survey_users WHERE id=$id")));
    }
    else {
        echo "Failed to insert!";
        var_dump(bin2hex(sha1('test'.$survey_salt, true)));
    }
    
    debug($_POST);
    
    $survey1 = new survey(FALSE, "Survey 1");
    
    $question1 = $survey1->add_question(question::truefalse, "True/False: Order 1", -1, -1, 0, 1);
    $question1->add_answer("TF Answer 1 DONT SHOW THIS!", 1);
    
    $question2 = $survey1->add_question(question::multichoice, "Multiple Choice: Order 2", -1, -1, 0, 2);
    $question2->add_answer("MC Answer 1", 1);
    $question2->add_answer("MC Answer 2");
    $question2->add_answer("MC Answer 3", 3);
    
    $question3 = $survey1->add_question(question::dropdown, "Dropdown: Order 3", -1, -1, 0, 3);
    $question3->add_answer("DD Answer 1");
    $question3->add_answer("DD Answer 2", 2);
    
    $question4 = $survey1->add_question(question::multiselect, "Multiple Select: Order 4", -1, -1, 0, 1);
    $question4->add_answer("MS Answer 2", 2);
    $question4->add_answer("MS Answer 1", 1);
    $question4->add_answer("MS Answer 3", 3);
    
    $question5 = $survey1->add_question(question::shortanswer, "Short Answer: Order 6", -1, -1, 0, 6);
    $question5->add_answer("SA Answer 1 DONT SHOW THIS!", 1);
    
    $question6 = $survey1->add_question(question::longanswer, "Long Answer: Order 5", -1, -1, 0, 5);
    $question6->add_answer("LA Answer 1 DONT SHOW THIS!", 1);
    
    $question7 = $survey1->add_question(question::multichoiceother, "Multiple Choice Other: Order 7", -1, -1, 0, 7);
    $question7->add_answer("MCO Answer 1");
    $question7->add_answer("MCO Answer 2");
    
    $question8 = new question(FALSE, question::multiselectother, "Multiple Select Other: Order 8", -1, -1, 0, 8);
    $question8->add_answer("MSO Answer 1");
    $question8->add_answer("MSO Answer 2");
    $survey1->add_qobject($question8);
    
    //$survey1->output_survey();
    debug($survey1);
    
    if (isset($_POST['survey-id'])) {
        $surveyOLD = new survey($_POST['survey-id']);
        debug($surveyOLD->get_answers());
        debug($surveyOLD);
    }
}