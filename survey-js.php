<?php
/**
    Loads the javascript file for the survey config page.
**/
function survey_admin_js() {
if (current_user_can('manage_options')) { ?>
<script type="text/javascript">
    //Simply return to the page that shows surveys.
    function show_surveys() {
        var data = {
            action: 'surveys_ajax',
            security: '<?php echo wp_create_nonce("surveys_nonce"); ?>',
        };
            
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#survey-questions-table').slideUp();
            jQuery('#survey-admin-page').html(response);
            jQuery('#survey-table').slideDown();
        });
    }
    
    //Show the questions contained within the selected survey.
    function select_survey(survey_id) {
        var data = {
            action: 'survey_select_ajax',
            security: '<?php echo wp_create_nonce("survey_select_nonce"); ?>',
            survey: survey_id
        };
            
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#survey-table').slideUp();
            jQuery('#survey-admin-page').html(response);
            jQuery('#survey-questions-table').slideDown();
        });
    }
        
    //Add a new question to the passed survey
    function add_question(survey_id, question_id) {
        var data = {
            action: 'survey_add_question_ajax',
            security: '<?php echo wp_create_nonce("survey_add_question_nonce"); ?>',
            survey: survey_id,
            question: question_id
        };
            
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#survey-questions-table').slideUp();
            jQuery('#survey-admin-page').html(response);
            jQuery('#survey-add-question').slideDown(400, function(){
                //Default to hiding the question setup until they select a question type.
                if (!question_id) jQuery('#questionsetup').hide();
                jQuery('#save_question').attr('onclick', 'submit_question('+survey_id+')');
                jQuery('#cancel_question').attr('onclick', 'select_survey('+survey_id+')');
                
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
        });
    }
    
    //Called when finished creating a question. This will add it to the survey and return to the questions list.
    function submit_question(survey_id) {
        var form_data;
        
        jQuery('#question-form').submit(function() {
            form_data = jQuery(this).serializeArray();
            return false;
        });
        
        jQuery('#question-form').submit();
        
        var data = {
            action: 'survey_submit_question_ajax',
            security: '<?php echo wp_create_nonce("survey_submit_question_nonce"); ?>',
            survey: survey_id,
            question: form_data
        };
        
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#survey-add-question').slideUp();
            jQuery('#survey-admin-page').html(response);
        });
        
        //Return the question list after saving the question.
        select_survey(survey_id);
    }
    
    function create_textbox(id, value) {
        var textbox = document.createElement('input');
        textbox.type = 'text';
        textbox.value = value;
        textbox.id = id;
        textbox.name = id;
        
        return textbox;
    }
    
    function edit_survey(survey_id) {
        var name = jQuery('#survey-'+survey_id+' :nth-child(2)');
        name.html(create_textbox('name-'+survey_id,  name.text()));
        
        var edit = jQuery('#survey-'+survey_id+' :nth-child(5)').children(':first-child');
        edit.attr('value', 'Save');
        edit.attr('onclick', 'save_survey(this, '+survey_id+')');
        
    }
    
    function save_survey(button, survey_id) {
        var edit = jQuery(button);
        edit.attr('value', 'Edit Name');
        edit.attr('onclick', 'edit_survey('+survey_id+')');
        
        var name = jQuery('#survey-'+survey_id+' :nth-child(2)');
        var value = name.children(':first-child').val();
        name.html(value);
        
        var data = {
            action: 'survey_edit_ajax',
            security: '<?php echo wp_create_nonce("survey_edit_nonce"); ?>',
            survey: survey_id,
            val: value
        };
        
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data);
    }
    
    function edit_question(survey_id, question_id) {
        add_question(survey_id, question_id);
    }
    
    //When the Add Answer button is pressed, this will get called.
    function add_answer(button) {
        //Grab the parent of the passed button, which should be the answer class.
        var answer = jQuery(button).parent();
        
        //Clone the entire answer contents
        var clone = answer.clone();
        
        //Modify the Number next to the textbox to show how many answers there are.
        var answernum = clone.children('.answernumber');
        jQuery(answernum).text((parseInt(answernum.html().substring(0, 1)) + 1) + ". ");
        
        //Make sure new answers use the default "answer" name instead of the possible answer with id name.
        var answertextbox = clone.children(':text');
        jQuery(answertextbox).attr('name', 'answer');
        jQuery(answertextbox).val(''); //Blank the value box as well.
        
        //Add the new clone to the list, and remove the button that was pressed so only one remains.
        jQuery('#answers').append(clone);
        jQuery(button).remove();
    }
        
    function remove_answer(button) {
        //Remove the selected answer.
        jQuery(button).parent().remove();
    }
</script>
<?php
}
}