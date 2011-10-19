<?php
/**
    Loads the javascript file for the survey config page.
**/
function survey_admin_js() {
if (current_user_can('manage_options')) { ?>
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
            jQuery('#survey-questions-table').slideUp();
            jQuery('#survey-add-question').slideDown(400, function(){
				//Default to hiding the question setup until they select a question type.
				jQuery('#questionsetup').hide();
				jQuery('#save_question').attr('onclick', 'submit_question('+survey_id+')');
				
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
            jQuery('#survey-admin-page').html(response);
            jQuery('#survey-add-question').slideUp();
            jQuery('#survey-questions-table').slideDown();
        });
		
		//Return the question list after saving the question.
		select_survey(survey_id);
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