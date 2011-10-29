<?php

add_action('init', 'set_survey_user_session');
function set_survey_user_session() {
    global $wpdb;
    
    if (isset($_POST['survey_username']) && survey_register_user()) {
        $query = "SELECT id FROM {$wpdb->prefix}survey_users WHERE username=%s";
        $user_id = $wpdb->get_var($wpdb->prepare($query, $_POST['survey_username']));
        $date = date('Y-m-d H:i:s');
        
        //Cookies expires in 1 hour.
        $id = setcookie('survey_u', $user_id, time()+60*60*1);
        $dc = setcookie('survey_hash', sha1($date), time()+60*60*1);    
        
        if (!$id || !$dc) {
            error_log("Failed to set cookie!");
            return FALSE;
        }
        else {
            //Update the logged in time with the same time as the cookie.
            $wpdb->update($wpdb->prefix.'survey_users', array('logged_in'=>$date), 
                          array('id'=>$user_id), array('%s'), array('%d'));
        }
    }
    
    return TRUE;
}

function get_survey_user_session() {
    global $wpdb;
    
    $user_id = intval($_COOKIE['survey_u']);
    $logged_in = $_COOKIE['survey_hash'];
    
    $query = $wpdb->prepare("SELECT logged_in FROM {$wpdb->prefix}survey_users WHERE id=%d", $user_id);
    $db_logged_in = $wpdb->get_var($query);
    
    //If the logged in time is the same as the one in the database, and it hasn't been an hour yet they're good.
    if (sha1($db_logged_in) == $logged_in && strtotime($db_logged_in) < (time()+60*60*1)) {
        return $user_id;
    }
    
    return FALSE;
}

function survey_register_user() {
    global $wpdb;
    global $survey_salt;
    global $survey_register_output;
    
    $insert = $wpdb->insert($wpdb->prefix.'survey_users', 
                            array('username'=>$_POST['survey_username'], 
                                  'password'=>sha1($_POST['survey_password'].$survey_salt, true), 
                                  'fullname'=>$_POST['survey_fullname'], 'physician'=>1), 
                            array('%s', '%s', '%s', '%d'));
    
    if ($insert !== FALSE) {
        $survey_register_output .= "<div id='survey-registration-success'>Survey Registration Success!</div>";
        return TRUE;
    }
    else {
        $survey_register_output .= "<div id='survey-registration-failed'>Survey Registration Failed. ".
                                   "Try a different username.</div>";
        return FALSE;
    }
}

/**
    Allows a shortcode to be created that will create a registration page. The shortcode is [survey-registration] 
**/
add_shortcode('survey-registration','survey_registration');
function survey_registration($atts, $content=null) {
    if (isset($_POST['survey_username'])) {
        global $survey_register_output;
        
        echo $survey_register_output;
        
        var_dump(get_survey_user_session());
    }
    else {
        echo "<h3>Registration Page</h3>\n". 
        "<form action='{$_SERVER['REQUEST_URI']}' method='post'>".
            "<div id='survey-registration'>".
            "  <div id='survey-username'>".
            "    <span>Username:</span> <input type='text' name='survey_username' maxlength='30' />".
            "  </div>".
            "  <div id='survey-password'>".
            "    <span>Password:</span> <input type='password' name='survey_password' maxlength='20' />".
            "  </div>".
            "  <div id='survey-fullname'>".
            "    <span>Full Name:</span> <input type='text' name='survey_fullname' maxlength='50' />".
            "  </div>".
            "  <div id='survey-submit'><input type='submit' value='Submit' /></div>".
            "</div>".
        "</form>";
    }
}