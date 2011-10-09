<?php
/*** Adds an option page for configuring the surveys. ***/
function survey_add_admin_link() {
    add_options_page('Survey Configuration', 'Survey Configuration', 'manage_options', 
                     'SurveyOptionsPage', 'survey_show_admin_page'); 
}
function survey_show_admin_page() {
    //Allows the user to manage the surveys and questions
    if (!current_user_can('manage_options'))  {
        wp_die( __('You do not have sufficient permissions to access this page.') );
    }
  
    if (isset($_POST['qtype'])) {
        debug($_POST);

        $qtype = $_POST['qtype'];
        $question = new question(false, $qtype, $_POST['qtext']);

        if ($qtype !== question::truefalse) {
            foreach ($_POST['answer'] as $answer) {
                $question->add_answer($answer);
            }
        }

        debug($question);
    }
  
?>
<script type="text/javascript">
    //A bit of jQuery to hide and show the question and answer stuff as necessary.
    jQuery(document).ready(function(){
        jQuery('#questionsetup').hide();
        
        //When the dropdown list changes, this gets called.
        jQuery("#qtype").change(function(){
            var qtype = jQuery("#qtype option:selected").val();
            if (qtype != 0) {
                if (qtype == 1) {
                    jQuery('#answers').hide();
                }
                else {
                    jQuery('#answers').slideDown();
                }
                jQuery('#questionsetup').slideDown();
            }
            else {
                jQuery('#questionsetup').slideUp();
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
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=SurveyOptionsPage">
    <select id="qtype" name="qtype">
        <option value="0">Select a question type</option>
        <option value="1">True/False</option>
        <option value="2">Multiple Choice</option>
        <option value="3">Drop-down List</option>
        <option value="4">Multiple Select</option>
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