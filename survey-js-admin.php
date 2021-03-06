<?php
/**
    Loads the javascript file for the survey config page.
**/
function survey_admin_js() {
if (current_user_can('manage_options')) { ?>
<link rel="stylesheet" href="<?php echo plugins_url('survey-style.css', __FILE__); ?>" type="text/css" />
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
    
    function create_survey() {
        var survey_name = jQuery('[name="new-survey-name"]').val();
        
        var data = {
            action: 'survey_create_ajax',
            security: '<?php echo wp_create_nonce("survey_create_nonce"); ?>',
            name: survey_name
        };
            
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(survey_id) {            
            var tr = "<tr id='survey-{$survey->id}'>"+
                     "  <td><input type='button' value='Select' onclick='select_survey("+survey_id+")' /></td>"+
                     "  <td>"+survey_name+"</td>"+
                     "  <td>0</td>"+
                     "  <td>10</td>"+
                     "  <td><input type='button' value='Edit Name' onclick='edit_survey("+survey_id+")' /></td>"+
                     "  <td><input type='button' value='Delete Survey' onclick='delete_survey("+survey_id+")' /></td>"+
                     "</tr>";
                     
            jQuery('#survey-table tbody').append(tr);
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
            
            // Initialise the table specifying an onDrop function that will allow for drag and drop reordering.
            jQuery("#survey-questions-table").tableDnD({
                onDrop: function(table, row) {
                    var post_order = {
                        action: 'survey_reorder_ajax',
                        security: '<?php echo wp_create_nonce("survey_reorder_nonce"); ?>',
                        survey: survey_id,
                        order: jQuery.tableDnD.serialize()
                    };
                    
                    jQuery.post(ajaxurl, post_order, function(response) {
                        console.log(response);
                    });
                },
                onDragStart: function(table, row) {
                    console.log("Started dragging row "+row.id);
                }
            });
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
                
                //When the question type dropdown list changes, this gets called.
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
                
                //Gets called when dependent question dropdown list changes.
                jQuery("#depquestion").change(function(){
                    var depquestion = jQuery("#depquestion option:selected").val();
                    
                    //Show or hide the dependent answers based on this selection.
                    if (depquestion != "-1") {
                        jQuery('#depanswer').slideDown();
                        
                        var depdata = {
                            action: 'survey_add_dependency_ajax',
                            security: '<?php echo wp_create_nonce("survey_add_dependency_nonce"); ?>',
                            depquestion: depquestion
                        };
                            
                        jQuery.post(ajaxurl, depdata, function(response) {
                            //If the response is 0 it's because that question type isn't supported.
                            if (response != "0") {
                                //Clear the list and then add recreate it.
                                jQuery('#depanswer').
                                    empty().
                                    append('<option value="-1">Select Dependent Question</option>').
                                    val('-1').
                                    append(response);
                            }
                        });
                    }
                    else {
                        jQuery('#depanswer').slideUp();
                        jQuery('#depanswer').
                            empty().
                            append('<option value="-1">Select Dependent Question</option>').
                            val('-1');
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
            jQuery('#survey-admin-page').html(response);
            //Return the question list after saving the question.
            select_survey(survey_id);
        });
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
        
        var questions = jQuery('#survey-'+survey_id+' :nth-child(4)');
        questions.html(create_textbox('questions-'+survey_id, questions.text()));
        
        var edit = jQuery('#survey-'+survey_id+' :nth-child(5)').children(':first-child');
        edit.attr('value', 'Save');
        edit.attr('onclick', 'save_survey(this, '+survey_id+')');
        
    }
    
    function delete_survey(survey_id) {
        var data = {
            action: 'survey_delete_ajax',
            security: '<?php echo wp_create_nonce("survey_delete_nonce"); ?>',
            survey: survey_id
        };
        
        var answer = confirm("Are you sure you want to delete this survey?");
        
        if (answer) {
            jQuery.post(ajaxurl, data, function(response){
                //Slide up the table row for the survey after deleting it.
                jQuery('#survey-'+survey_id).slideUp();
            });
        }
    }
    
    function save_survey(button, survey_id) {
        var edit = jQuery(button);
        edit.attr('value', 'Edit Name');
        edit.attr('onclick', 'edit_survey('+survey_id+')');
        
        var name = jQuery('#survey-'+survey_id+' :nth-child(2)');
        var name_value = name.children(':first-child').val();
        name.html(name_value);
        
        var questions = jQuery('#survey-'+survey_id+' :nth-child(4)');
        var questions_value = questions.children(':first-child').val();
        questions.html(questions_value);
        
        var data = {
            action: 'survey_edit_ajax',
            security: '<?php echo wp_create_nonce("survey_edit_nonce"); ?>',
            survey: survey_id,
            name: name_value,
            questions: questions_value
        };
        
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response){console.log(response);});
    }
    
    function edit_question(survey_id, question_id) {
        add_question(survey_id, question_id);
    }
    
    function delete_question(survey_id, question_id) {
        var data = {
            action: 'survey_question_delete_ajax',
            security: '<?php echo wp_create_nonce("survey_question_delete_nonce"); ?>',
            survey: survey_id,
            question: question_id
        };
        
        var answer = confirm("Are you sure you want to delete this question?");
        
        if (answer) {
            jQuery.post(ajaxurl, data, function(response){
                //Slide up the table row for the question after deleting it.
                jQuery('#question-'+question_id).slideUp();
            });
        }
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
        var clone = jQuery(button).clone();
        
        //Remove the selected answer.
        jQuery(button).parent().remove();
        
        
    }
</script>
<?php
}
}