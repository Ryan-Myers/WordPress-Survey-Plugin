<?php
/**
    The starting page for editing a survey. This will allow the user to manage the surveys and questions/answers.
**/
function survey_show_admin_page() {
    global $wpdb;
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    $query = "SELECT id, name, questions, questionsperpage FROM {$wpdb->prefix}survey";
    $surveys = $wpdb->get_results($query);
    
    echo "<h2>Survey Configuration</h2><div id='survey-admin-page' class='wrap'>
            <table id='survey-table' border='3' cellspacing='10'>
                <thead style='font-weight:bold'>
                    <tr><td>Name</td><td>Questions</td><td>Questions Per Page</td><td></td></tr>
                </thead>
                <tbody>";
    
    foreach ($surveys as $survey) {
        echo      "<tr>\n".
                  "  <td>{$survey->name}</td>\n".
                  "  <td>".count(explode(',', $survey->questions))."</td>\n".
                  "  <td>{$survey->questionsperpage}</td>\n".
                  "  <td><input type='button' value='Select' onclick='select_survey({$survey->id})' /></td>\n".
                  "</tr>\n";
    }

    echo "</tbody></table></div>";
}

/**
    This gets called from the survey question selection ajax, and outputs the list of questions for that survey.
**/
function survey_select_ajax_callback() {
    global $wpdb;
    check_ajax_referer('survey_select_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    //Gather the list of questions in this survey based on the passed survey id.
    $survey_id = intval($_POST['survey']);
    $query = "SELECT questions FROM {$wpdb->prefix}survey WHERE id = %d";
        
    //Explode the questions into an array.
    $questions = explode(',', $wpdb->get_var($wpdb->prepare($query, $survey_id)));
        
    echo "<table id='survey-questions-table' border='3' cellspacing='10' style='display:none'>".
         "<thead style='font-weight:bold'><tr><td>Question</td><td>Question Type</td></tr></thead><tbody>";
        
    foreach ($questions as $question_id) {
        $query = "SELECT question,questiontype FROM {$wpdb->prefix}survey_questions WHERE id=%d ORDER BY ordernum";
        $row = $wpdb->get_row($wpdb->prepare($query, $question_id));
        echo "<tr><td>{$row->question}</td><td>{$row->questiontype}</td></tr>";
    }
        
    echo "</tbody></table><br />";
    echo "<input type='button' value='Add New Question' onclick='add_question($survey_id)' />";
    
	die(); // this is required to return a proper result
}

/**
    Get's called from the survey questions list when they click to add a new question.
**/
function survey_add_question_ajax_callback() {
    check_ajax_referer('survey_add_question_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }  
    ?>
    <form id="question-form">
        <div id="survey-add-question" class="wrap">
            <select id="qtype" name="qtype">
                <option value="0">Select a question type</option>
                <option value="1">True/False</option>
                <option value="2">Multiple Choice</option>
                <option value="7">Multiple Choice / Other</option>
                <option value="3">Drop-down List</option>
                <option value="4">Multiple Select</option>
                <option value="8">Multiple Select / Other</option>
                <option value="5">Short Answer</option>
                <option value="6">Long Answer</option>
            </select><br />
            <div id="questionsetup">
                <span>Question Text: <input type="text" name="qtext" /></span><br />
                <div id="answers">
                    <div class="answer">
                        <span class="answernumber">1.</span>
                        <input type="text" name="answer" /> 
                        <input type="button" value="Add Answer" onclick="add_answer(this)" />
                    </div>
                </div>
                <input id="save_question" type="button" value="Save Question" onclick="submit_question(1)" />
            </div>
        </div>
    </form>
    <?php
    
    die();// this is required to return a proper result
}

function survey_submit_question_ajax_callback() {
    check_ajax_referer('survey_submit_question_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    //Set up the basic structure for the question array.
    $question = array('qtype'=>'', 'qtext'=>'', 'answers'=>array());
    
    //Fill in the array properly using the posted data.
    foreach($_POST['question'] as $posted) {
        if ($posted['name'] == 'answer') {
            $question['answers'][] = $posted['value'];
        }
        else {
            $question[$posted['name']] = $posted['value'];
        }
    }
    
    $qobject = new question(false, $question['qtype'], $question['qtext']);
        
    switch ($question['qtype']) {
        case question::truefalse:
        case question::shortanswer:
        case question::longanswer:
            //These question types don't have answers.
            break;
        default:
            foreach ($question['answers'] as $answer) {
                $qobject->add_answer($answer);
            }
    }
    
    $survey = new survey($_POST['survey']);
    $survey->add_qobject($qobject);
    
    echo "Question added to the survey!";
    
    die();// this is required to return a proper result
}