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
                    <tr><td></td><td>Name</td><td>Questions</td><td>Questions Per Page</td><td></td><td></td></tr>
                </thead>
                <tbody>";
    
    foreach ($surveys as $survey) {
        //questions_count is here to account for an empty list of questions. 
        //If it's empty the array still contains an empty string, which would get counted as one question.
        $questions_count = explode(',', $survey->questions);
        $questions_count = (empty($questions_count[0])) ? 0 : count($questions_count);
        
        echo    "<tr id='survey-{$survey->id}'>\n".
                "  <td><input type='button' value='Select' onclick='select_survey({$survey->id})' /></td>\n".
                "  <td>{$survey->name}</td>\n".
                "  <td>{$questions_count}</td>\n".
                "  <td>{$survey->questionsperpage}</td>\n".
                "  <td><input type='button' value='Edit' onclick='edit_survey({$survey->id})' /></td>\n".
                "  <td><input type='button' value='Delete Survey' onclick='delete_survey({$survey->id})' /></td>\n".
                "</tr>\n";
    }

    echo    "</tbody>".
            "<tfoot>".
            "<tr>".
            "  <td>New Survey:</td>".
            "  <td colspan='3'><input type='text' name='new-survey-name' /></td>".
            "  <td><input type='button' value='Add Survey' onclick='create_survey()' /></td>".
            "</tr>".
            "</tfoot>".
            "</table></div>";
}

/**
    Called when creating a new survey. Currently only gets passed the name, and returns the survey's ID.
**/
function survey_create_ajax_callback() {
    check_ajax_referer('survey_create_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    $survey = new survey(FALSE, $_POST['name']);
    
    echo $survey->id; //Echo the survey id as a way of passing it back to the page.
    
    die();// this is required to return a proper result
}

/**
    Ajax enabled version of the above function. Called when cancel button is clicked in adding questions page.
**/
function survey_surveys_ajax_callback() {
    check_ajax_referer('surveys_nonce', 'security');
    
    survey_show_admin_page();
    
    die();// this is required to return a proper result
}

/**
    This gets called when saving changes to a survey name. Simply updates the database with the new name.
**/
function survey_edit_ajax_callback() {
    global $wpdb;
    check_ajax_referer('survey_edit_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    $wpdb->update($wpdb->prefix.'survey', 
                  array('name'=>stripslashes($_POST['name']),//Strip the slashes that the AJAX call seems to add.
                        'questionsperpage'=>stripslashes($_POST['questions'])),//Strip the slashes again.
                  array('id'=>intval($_POST['survey'])), 
                  array('%s', '%d'), array('%d'));
    
    die();
}

/**
    This gets called when deleteing a survey. It simply deletes the survey and all of its questions.
    
    TODO: In the future, if the ability to use the same question in multiple surveys happens, 
    this will need to be fixed.
**/
function survey_delete_ajax_callback() {
    global $wpdb;
    check_ajax_referer('survey_delete_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    $survey_id = intval($_POST['survey']);
    
    //Gather the comma seperated list of questions form the survey table.
    $questions = $wpdb->get_var($wpdb->prepare("SELECT questions FROM {$wpdb->prefix}survey WHERE id=%d", $survey_id));
    
    //For every question, delete it and all of it's answers.
    foreach (explode(',', $questions) as $question_id) {
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}survey_questions WHERE id=%d", $question_id));
        $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}survey_answers WHERE question=%d", $question_id));
    }
    
    //Finally, delete the survey itself.
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}survey WHERE id=%d", $survey_id));
    
    die();
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
    
    if (empty($questions[0])) {
        $questions = array();
    }
    
    echo "<table id='survey-questions-table' border='3' cellspacing='10' style='display:none'>".
    "<thead style='font-weight:bold'><tr><td>Question</td><td>Question Type</td><td></td><td></td></tr></thead><tbody>";
    
    foreach ($questions as $question_id) {
        $query = "SELECT question,questiontype FROM {$wpdb->prefix}survey_questions WHERE id=%d";
        $row = $wpdb->get_row($wpdb->prepare($query, $question_id));
        echo "<tr id='question-{$question_id}'>\n".
             "  <td>{$row->question}</td>\n".
             "  <td>{$row->questiontype}</td>\n".
             "  <td><input type='button' value='Edit' onclick='edit_question($survey_id, $question_id)' /></td>\n".
             "  <td><input type='button' value='Delete' onclick='delete_question($survey_id, $question_id)' /></td>\n".
             "</tr>\n";
    }
        
    echo "</tbody></table><br />";
    echo "<input type='button' value='Add New Question' onclick='add_question($survey_id)' />";
    echo "<input type='button' value='Cancel' onclick='show_surveys()' />";
    
	die(); // this is required to return a proper result
}

/**
    This gets called when deleting a question. 
    Deletes the question, answer and removes all references to it from the survey.
**/
function survey_question_delete_ajax_callback() {
    global $wpdb;
    check_ajax_referer('survey_question_delete_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    $survey_id = intval($_POST['survey']);
    $question_id = intval($_POST['question']);
    
    //Gather the comma seperated list of questions form the survey table.
    $questions = $wpdb->get_var($wpdb->prepare("SELECT questions FROM {$wpdb->prefix}survey WHERE id=%d", $survey_id));
    
    //Make the questions an array and remove the question id being deleted, then implode it again.
    $questions = implode(',', array_diff(explode(',', $questions), array($question_id)));
    
    //Put the new list of questions back into the survey.
    $wpdb->update($wpdb->prefix.'survey', 
                array('questions'=>$questions), 
                array('id'=>$survey_id), 
                array('%s'), array('%d'));
    
    //Delete all of the answers to this question.
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}survey_answers WHERE question=%d", $question_id));
    
    //Finally, delete the question itself.
    $wpdb->query($wpdb->prepare("DELETE FROM {$wpdb->prefix}survey_questions WHERE id=%d", $question_id));
    
    die();
}

/**
    Get's called from the survey questions list when they click to add a new question.
**/
function survey_add_question_ajax_callback() {
    global $wpdb;
    check_ajax_referer('survey_add_question_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    //If this is being edited, the question id will be posted.
    if (isset($_POST['question'])) {
        $query = "SELECT question,questiontype,dependentquestion,dependentanswer 
                  FROM {$wpdb->prefix}survey_questions WHERE id=%d";
        $row = $wpdb->get_row($wpdb->prepare($query, intval($_POST['question'])));
        $qt = intval($row->questiontype);
        $dq = intval($row->dependentquestion);
        $da = intval($row->dependentanswer);
        
        $query = "SELECT id,answer FROM {$wpdb->prefix}survey_answers WHERE question=%d AND hidden=0 ORDER BY ordernum";
        $answers = $wpdb->get_results($wpdb->prepare($query, intval($_POST['question'])), ARRAY_N);
    }
    else {
        //Default these values to noting to allow things to progress later on.
        $row->question = '';
        $answers[0][0] = "";
        $qt = NULL;
        $dq = -1;
        $da = -1;
    }
    ?>
    <form id="question-form">
        <div id="survey-add-question" class="wrap">
            <select id="qtype" name="qtype">
                <option value="0" <?php if ($qt === 0) echo 'selected="selected"'; ?>>Select a question type</option>
                <option value="1" <?php if ($qt === 1) echo 'selected="selected"'; ?>>True/False</option>
                <option value="2" <?php if ($qt === 2) echo 'selected="selected"'; ?>>Multiple Choice</option>
                <option value="7" <?php if ($qt === 7) echo 'selected="selected"'; ?>>Multiple Choice / Other</option>
                <option value="3" <?php if ($qt === 3) echo 'selected="selected"'; ?>>Drop-down List</option>
                <option value="4" <?php if ($qt === 4) echo 'selected="selected"'; ?>>Multiple Select</option>
                <option value="8" <?php if ($qt === 8) echo 'selected="selected"'; ?>>Multiple Select / Other</option>
                <option value="5" <?php if ($qt === 5) echo 'selected="selected"'; ?>>Short Answer</option>
                <option value="6" <?php if ($qt === 6) echo 'selected="selected"'; ?>>Long Answer</option>
            </select><br />
            <div id="questionsetup">
                <span>Question Text: <input type="text" name="qtext" value="<?php echo $row->question; ?>" /></span>
                <br />
                <div id="answers">
                <?php
                    //If this is being edited, it will output an answer class for each answer already existing.
                    $answer_count = count($answers);
                    $count = 1;
                    foreach($answers as $answer) { 
                        echo "<div class='answer'>".
                             "<span class='answernumber'>{$count}.</span>";
                        
                        //If this is being edited, make the name like 1-answer where 1 is the answer id.
                        //Also use the value of that answer as the default.
                        if (isset($_POST['question'])) {
                            echo "<input type='text' name='{$answer[0]}-answer' value='{$answer[1]}' />";
                        }
                        else {
                            echo "<input type='text' name='answer' />";
                        }
                            
                        //Only show the Add Answer button on the last answer.
                        if ($count == $answer_count) {
                            echo '<input type="button" value="Add Answer" onclick="add_answer(this)" />';
                        }
                        
                        echo '</div>';
                        $count++; 
                    }
                ?>
                </div>
                <div id="dependent">
                    <p>If this question should only be shown to users who answered another question with a particular
                    answer, then select that question, and the answer that needed to be chosen.</p>
                    <select id="depquestion" name="depquestion">
                        <option value="-1">Select Dependent Question</option>
                        <?php
                            //Gather the list of questions for this 
                            $query = "SELECT questions FROM {$wpdb->prefix}survey WHERE id=%d";
                            $questions = explode(',', $wpdb->get_var($wpdb->prepare($query, intval($_POST['survey']))));
                            
                            //Double check that it's not empty. 
                            //Exploding nothing will create a single entry with an empty string.
                            $questions = (!empty($questions)) ? $questions : array();
                            
                            foreach($questions as $question) {
                                $query="SELECT question,questiontype FROM {$wpdb->prefix}survey_questions WHERE id=%d";
                                $qarray = $wpdb->get_results($wpdb->prepare($query, $question));
                                
                                if (!empty($qarray)) {
                                    $qobject = $qarray[0];
                                    
                                    //Don't display question types that can't be dependent.
                                    if ($qobject->questiontype != question::shortanswer && 
                                        $qobject->questiontype != question::longanswer) {
                                        
                                        $selected = ($question == $row->dependentquestion) ? "selected='selected'" : "";
                                        
                                        echo "<option value='{$question}' $selected>{$qobject->question}</option>";
                                    }
                                }
                            }
                        ?>
                    </select><br />
                    <select id="depanswer" name="depanswer" <?php if ($dq == -1) echo 'style="display:none"'; ?>>
                        <option value="-1">Select Dependent Answer</option>
                        <?php
                            if ($dq != -1) {
                                survey_get_dependent_answers($dq, $da);
                            }
                        ?>
                    </select>
                </div>
                <input id="save_question" type="button" value="Save Question" onclick="submit_question(1)" />
            </div>
            <input id="cancel_question" type="button" value="Cancel" onclick="select_survey(1)" />
        </div>
        <?php
            //This will create a hidden value containing the question id if this is being edited.
            if (isset($_POST['question'])) 
                echo '<input type="hidden" name="survey_edit" value="'.intval($_POST['question']).'" />';
        ?>
    </form>
    <?php
    
    die();// this is required to return a proper result
}

function survey_get_dependent_answers($depquestion, $depanswer = -1) {
    global $wpdb;
    
    //Grab the question type to determine how to handle the options.
    $query = "SELECT questiontype FROM {$wpdb->prefix}survey_questions WHERE id=%d";
    $qtype = $wpdb->get_var($wpdb->prepare($query, $depquestion));
   
    switch ($qtype) {
        //True/False questions don't have answers becuase it's always the same two.
        case question::truefalse:
            $selected1 = ($depanswer === 1) ? "selected='selected'" : ""; 
            $selected0 = ($depanswer === 0) ? "selected='selected'" : ""; 
            echo "<option value='1' $selected1>True</option>";
            echo "<option value='0' $selected0>False</option>";
        break;
        
        //Can't reasonably expect short/long answers to be a dependent question.
        case question::shortanswer:
        case question::longanswer:
            echo "0";
        break;
        
        //For all other question types that have answers.
        default:
            //Gather the list of answers for all questions that have them.
            $query = "SELECT id, answer FROM {$wpdb->prefix}survey_answers WHERE question=%d";
            $answers = $wpdb->get_results($wpdb->prepare($query, $depquestion));
            
            foreach($answers as $answer) {
                $selected = ($depanswer == $answer->id) ? "selected='selected'" : "";
                echo "<option value='{$answer->id}' $selected>{$answer->answer}</option>";
            }
    }
}

function survey_add_dependency_ajax_callback() {
    check_ajax_referer('survey_add_dependency_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    survey_get_dependent_answers(intval($_POST['depquestion']));
    
    die();
}

function survey_submit_question_ajax_callback() {
    check_ajax_referer('survey_submit_question_nonce', 'security');
    
    //Make sure they're logged in with the appropriate permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    //Set up the basic structure for the question array.
    $question = array('qtype'=>'', 'qtext'=>'', 'answers'=>array());
    
    //This array will keep track of all of the answer ids being edited.
    $edit = array();
    
    //Fill in the array properly using the posted data.
    foreach($_POST['question'] as $posted) {
        //If the name is answer then it's a brand new answer and not being edited.
        if ($posted['name'] == 'answer') {
            $question['answers'][] = $posted['value'];
        }
        //If the name is like 1-answer, the 1 would be the answer id to edit.
        elseif (strstr($posted['name'], '-answer') !== FALSE) {
            $answer_id = strstr($posted['name'], '-answer', TRUE);
            $question['answers'][$answer_id] = $posted['value'];
            $edit[] = $answer_id;
        }
        //Otherwise it's not an answer at all and something else.
        else {
            $question[$posted['name']] = $posted['value'];
        }
    }
    
    //If the question is being edited, then this will use the id of that question to create the qobject.
    if (isset($question['survey_edit'])) {
        $qobject = new question(intval($question['survey_edit']));
        $qobject->edit_question($question['qtext']);
        $qobject->edit_type($question['qtype']);
        $qobject->edit_dependency($question['depquestion'], $question['depanswer']);
    }
    else {
        $qobject = new question(FALSE, $question['qtype'], $question['qtext'], 
                                       $question['depquestion'], $question['depanswer']);
    }
    
    switch ($question['qtype']) {
        case question::truefalse:
        case question::shortanswer:
        case question::longanswer:
            //These question types don't have answers.
            break;
        default:
            foreach ($question['answers'] as $answer_id=>$answer) {
                //If the answer id is in the array, then it must be edited, otherwise it's a new answer.
                if (in_array($answer_id, $edit)) {
                    $qobject->edit_answer($answer_id, $answer);
                }
                else {
                    $qobject->add_answer($answer);
                }
            }
    }
    
    
    //Don't add a new question to the survey list if it's being edited.
    if (!isset($question['survey_edit'])) {
        $survey = new survey(intval($_POST['survey']));
        $survey->add_qobject($qobject);
    }
    
    echo "Success!";
    
    die();// this is required to return a proper result
}