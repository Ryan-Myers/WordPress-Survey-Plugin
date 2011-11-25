<?php header("Content-type: text/javascript"); @require_once('../../../wp-config.php'); ?>

//When the screen loads default to showing the first page.
jQuery(document).ready(function(){
    jQuery('#survey-prev-page-1').hide();
    jQuery('#survey-form-page-1').show();
});

function survey_post_form_data(page) {
    var form_data;
    
    //Set up how to handle the form being submitted. This fills in the form data with a serialized array.
    jQuery('#survey-form-page-'+page).submit(function() {
        form_data = jQuery(this).serializeArray();
        return false;
    });
    
    //Submit the form to get the data into form_data.
    jQuery('#survey-form-page-'+page).submit();
    
    //Set up an array of data to post over ajax.
    var data = {
        page: page,
        form: form_data
    };
    
    //Posts to survey-js-ajax.php
    jQuery.post('<?php echo plugins_url("survey-js-ajax.php", __FILE__); ?>', data, function(response){
        //console.log(response);
    });
}

function survey_next_page(page, lastpage) {
    var nextpage;
    nextpage = page+1;
    
    survey_post_form_data(page);
    
    //As long as this isn't the last page, hide the current page and show the next page.
    if (page < lastpage) { 
        jQuery('#survey-form-page-'+page).hide();
        jQuery('#survey-form-page-'+nextpage).show();
    }
    
    //If it's now on the last page, change the "Next Page" button to say "Submit".
    if (nextpage == lastpage) {
        jQuery('#survey-next-page-'+nextpage).val('Submit Survey');
        jQuery('#survey-next-page-'+nextpage).attr('onclick', 'survey_finish('+lastpage+')');
    }
}

function survey_prev_page(page, lastpage) {
    var prevpage;
    prevpage = page-1;
    
    survey_post_form_data(page);
    
    //As long as this isn't the first page, hide the current page and show the previous page.
    if (page > 1) {
        jQuery('#survey-form-page-'+page).hide();
        jQuery('#survey-form-page-'+prevpage).show();
    }
    
    if (page == lastpage) {
        jQuery('#survey-next-page-'+page).val('Next Page');
        jQuery('#survey-next-page-'+page).attr('onclick', 'survey_submit('+lastpage+')');
    }
}

function select_answer(question_id, answer_id) {
    var data = {
        question: question_id,
        answer: answer_id
    };
    
    //Show the question that depends on this question and answer.
    jQuery.post('<?php echo plugins_url("survey-js-question-ajax.php", __FILE__); ?>', data, function(response){
        var obj = jQuery.parseJSON(response);
        jQuery.each(obj, function(index, value) {
            jQuery(value).parent().parent().parent().slideDown();
        });
    });
    
    var data = {
        question: question_id,
        answer: answer_id,
        hide: '1'
    };
    
    //Hide the dependent questions that haven't been chosen.
    jQuery.post('<?php echo plugins_url("survey-js-question-ajax.php", __FILE__); ?>', data, function(response){
        var obj = jQuery.parseJSON(response);
        jQuery.each(obj, function(index, value) {
            jQuery(value).parent().parent().parent().slideUp();
        });
    });
}

function survey_submit(page) {
    survey_post_form_data(page);
}

function survey_finish(page) {
    survey_post_form_data(page);
    jQuery('#survey-complete').show();
}

function survey_generate_pdf(appendix_id) {
    var patient_id;
    patient_id = jQuery('#survey_patient').val();

    var data = {
        appendix: appendix_id,
        patient: patient_id
    };
    
    jQuery.post('<?php echo plugins_url("survey-generate-pdf.php", __FILE__); ?>', data, function(response){
        console.log(response);
        window.location.href = response;
    });
}