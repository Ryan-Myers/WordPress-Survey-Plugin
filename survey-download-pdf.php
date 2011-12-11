<?php
@require_once('../../../wp-config.php');

//Verify that it's a physician looking to download this form.
//if (is_physician(get_survey_user_session())) {
    $folder = sys_get_temp_dir();
    $file = "appendix-{$_GET['file']}.pdf";

    /*
    //Force download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . $file . ';');
    header('Content-Length: ' . filesize($folder . '/' . $file));
    */
    
    //Show in browser.
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="' . $file . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($folder . '/' . $file));
    //Attempt to force the browser to not cache the PDF.
    header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1
    header('Pragma: no-cache'); // HTTP 1.0
    header('Expires: 0'); // Proxies
    header('Accept-Ranges: bytes');
    
    readfile($folder . '/' . $file);
//}