<?php
/*** Adds an option page for configuring the surveys. ***/
function survey_add_admin_link() {
    add_options_page('Survey Configuration', 'Survey Configuration', 'manage_options', 
                     'SurveyOptionsPage', 'survey_show_admin_page'); 
}

//This gets called from the survey question selection ajax
function survey_select_ajax_callback() {
    global $wpdb;
    check_ajax_referer('survey_nonce', 'security');
    
    //Make sure they're logged in as an admin.
    if (is_admin()) {
        $survey_id = intval($_POST['survey']);?>
        <table id='survey-questions-table' border='3' cellspacing='10' style='display:none'>
            <thead style='font-weight:bold'>
                <tr><td>Question</td><td>Question Type</td></tr>
            </thead>
            <tbody>
<?php
        //Gather the list of questions in this survey based on the passed survey id.
        $query = "SELECT questions FROM {$wpdb->prefix}survey WHERE id = %d";
        $questions = explode(',', $wpdb->get_var($wpdb->prepare($query, $survey_id)));
        
        foreach ($questions as $question_id) {
            $query = "SELECT question, questiontype FROM {$wpdb->prefix}survey_questions WHERE id = %d ORDER BY ordernum";
            $row = $wpdb->get_row($wpdb->prepare($query, $question_id));
            echo "<tr><td>{$row->question}</td><td>{$row->questiontype}</td></tr>";
        }
?>
            </tbody>
        </table><?php
    }
    
	die(); // this is required to return a proper result
}

function survey_show_admin_page() {
    global $wpdb;
    
    //Allows the user to manage the surveys and questions
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
    
    $ajax_nonce = wp_create_nonce("survey_nonce");
?>
<script type="text/javascript">
    function select_survey(survey_id) {
        //jQuery('#survey-table').hide();
        
        var data = {
            action: 'survey_select_ajax',
            security: '<?php echo $ajax_nonce; ?>',
            survey: survey_id
        };
        
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#survey-admin-page').html(response);
            jQuery('#survey-table').slideUp();
            jQuery('#survey-questions-table').slideDown();
        });
    }
</script>
<div id='survey-admin-page'>
<table id='survey-table' border='3' cellspacing='10'>
    <thead style='font-weight:bold'>
        <tr><td>Name</td><td>Questions</td><td>Questions Per Page</td><td></td></tr>
    </thead>
    <tbody>
<?php
    $query = "SELECT id, name, questions, questionsperpage FROM {$wpdb->prefix}survey";
    $surveys = $wpdb->get_results($query);
    
    foreach ($surveys as $survey) {
        echo      "<tr>\n".
                  "  <td>{$survey->name}</td>\n".
                  "  <td>".count(explode(',', $survey->questions))."</td>\n".
                  "  <td>{$survey->questionsperpage}</td>\n".
                  "  <td><input type='button' value='Select' onclick='select_survey({$survey->id})' /></td>\n".
                  "</tr>\n";
    }
?>
    </tbody>
</table>
</div><?php
}

function survey_show_admin_page_OLD() {
    //Allows the user to manage the surveys and questions
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
  
    if (isset($_POST['qtype'])) {
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
    }
  
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
                    //If it's still the default "Select a question type" then don't display any part of the question.
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
<div class="wrap">
<h2>Survey Configuration</h2>
<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
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
        <input type="submit" text="Submit" />
    </div>
</form>
</div>
<?php
}