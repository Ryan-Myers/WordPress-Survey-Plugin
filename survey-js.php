<?php header("Content-type: text/javascript"); @require_once('../../../wp-config.php'); ?>

jQuery(document).ready(function(){
    jQuery('#survey-form-page-1').show();
});

function survey_page(page, lastpage) {
    var form_data;
    
    //Set up how to handle the form being submitted
    jQuery('#survey-form-page-'+page).submit(function() {
        form_data = jQuery(this).serializeArray();
        return false;
    });
        
    jQuery('#survey-form-page-'+page).submit();
    
    if (page < lastpage) { 
        jQuery('#survey-form-page-'+page).hide();
        jQuery('#survey-form-page-'+(page+1)).show();
    }
    
    if ((page+1) == lastpage) {
        jQuery('#survey-next-page-'+(page+1)).val('Submit');
    }
    
    var data = {
        page: page,
        question: form_data
    };
    
    jQuery.post('<?php echo plugins_url("survey-js-ajax.php", __FILE__); ?>', data, function(response){
        alert(response);
    });
}