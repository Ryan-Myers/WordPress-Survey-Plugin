<?php
/**
    The starting page for editing a survey. This will allow the user to manage the surveys and questions/answers.
**/
function survey_show_admin_page() {
    global $wpdb;
    
    //Verifies permissions.
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    ?>
    <script type="text/javascript">
        function select_survey(survey_id) {
            var data = {
                action: 'survey_select_ajax',
                security: '<?php echo wp_create_nonce("survey_select_nonce"); ?>',
                survey: survey_id
            };
            
            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                jQuery('#survey-admin-page').html(response);
                jQuery('#survey-table').slideUp();
                jQuery('#survey-questions-table').slideDown();
            });
        }
        
        //Add a new question to the passed survey
        function add_question(survey_id) {
            var data = {
                action: 'survey_add_question_ajax',
                security: '<?php echo wp_create_nonce("survey_add_question_nonce"); ?>',
                survey: survey_id
            };
            
            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajaxurl, data, function(response) {
                jQuery('#survey-admin-page').html(response);
                jQuery('#survey-table').slideUp();
                jQuery('#survey-questions-table').slideUp();
                jQuery('#survey-add-question').slideDown();
            });
        }
    </script>
    <?php
    
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
    echo "<input type='button' value='Add New Question' onClick='add_question($survey_id)' />";
    
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
  
    /*if (isset($_POST['qtype'])) {
        $qtype = $_POST['qtype'];
        $question = new question(false, $qtype, $_POST['qtext']);
        
        switch ($qtype) {
            case question::truefalse:
            case question::shortanswer:
            case question::longanswer:
                //These question types don't have answers.
                break;
            default:
                foreach ($_POST['answer'] as $answer) {
                    $question->add_answer($answer);
                }
        }
        
        $survey = new survey(1);
        $survey->add_qobject($question);
        
        echo "Question added to the survey!";
    }*/
  
    ?>
    <script type="text/javascript">
        //A bit of jQuery to hide and show the question and answer stuff as necessary.
        jQuery(document).ready(function(){
            jQuery('#questionsetup').hide();
            
            //When the dropdown list changes, this gets called.
            jQuery("#qtype").change(function(){
                var qtype = jQuery("#qtype option:selected").val();
                switch(qtype) {
                    case "0":
                        //If it's still the default selection then don't display any part of the question.
                        jQuery('#questionsetup').slideUp();
                        break;
                    case "1": //True/False
                    case "5": //Short Answer
                    case "6": //Long Answer
                        //Don't show the answers for questions that don't have any.
                        jQuery('#answers').hide();
                        jQuery('#questionsetup').slideDown();
                        break;
                    default:
                        //Show the answers for every other question type.
                        jQuery('#answers').slideDown();
                        jQuery('#questionsetup').slideDown();
                }
            });
        });
        
        //When the Add Answer button is pressed, this will get called.
        function add_answer(button) {
            //Grab the parent of the passed button, which should be the answer class.
            var answer = jQuery(button).parent();
            
            //Clone the entire answer contents
            var clone = answer.clone();
            
            //Modify the Number next to the textbox to show how many answers there are.
            var answernum = clone.children('.answernumber');
            jQuery(answernum).text((parseInt(answernum.html().substring(0, 1)) + 1) + ". ");
            
            //Add the new clone to the list, and remove the button that was pressed so only one remains.
            jQuery('#answers').append(clone);
            jQuery(button).remove();
        }
        
        function remove_answer(button) {
            //Remove the selected answer.
            jQuery(button).parent().remove();
        }
    </script>
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
                    <input type="text" name="answer[]" /> 
                    <input type="button" value="Add Answer" onclick="add_answer(this)" />
                </div>
            </div>
            <input type="button" text="Add" />
        </div>
    </div>
    <?php
    
    die();// this is required to return a proper result
}