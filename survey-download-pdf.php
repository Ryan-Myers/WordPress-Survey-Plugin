<?php
@require_once('../../../wp-config.php');

//Verify that it's a physician looking to download this form.
if (is_physician(get_survey_user_session())) {
    $folder = sys_get_temp_dir();
    $file = $_GET['file'];

    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename=' . $file . ';');
    header('Content-Length: ' . filesize($folder . '/' . $file));

    readfile($folder . '/' . $file);
}