<?php

add_action('init', 'set_survey_user_session');
function set_survey_user_session() {
    global $wpdb;
    
    if (isset($_POST['survey_username-l']) && survey_login_user()) {
        $username = $_POST['survey_username-l'];
    }
    
    if (isset($_POST['survey_username-r']) && survey_register_user()) {
        $username = $_POST['survey_username-r'];
    }
    
    if (isset($username)) {
        $query = "SELECT id FROM {$wpdb->prefix}survey_users WHERE username=%s";
        $user_id = $wpdb->get_var($wpdb->prepare($query, $username));
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
    
    if (isset($_COOKIE['survey_u'])) {
        $user_id = intval($_COOKIE['survey_u']);
        $logged_in = $_COOKIE['survey_hash'];
        
        $query = $wpdb->prepare("SELECT logged_in FROM {$wpdb->prefix}survey_users WHERE id=%d", $user_id);
        $db_logged_in = $wpdb->get_var($query);
        
        //If the logged in time is the same as the one in the database, and it hasn't been an hour yet they're good.
        if (sha1($db_logged_in) == $logged_in && strtotime($db_logged_in) < (time()+60*60*1)) {
            return $user_id;
        }
    }
    
    return FALSE;
}

function survey_login_user() {
    global $wpdb;
    global $survey_salt;
    global $survey_register_output;
    
    $survey_register_output .= print_r($_POST, true);
}

function survey_register_user() {
    global $wpdb;
    global $survey_salt;
    global $survey_register_output;
    
    $insert = $wpdb->insert($wpdb->prefix.'survey_users', 
                            array('username'=>$_POST['survey_username-r'], 
                                  'password'=>sha1($_POST['survey_password-r'].$survey_salt, true), 
                                  'fullname'=>$_POST['survey_fullname-r'], 'physician'=>$_POST['survey_physician-r']), 
                            array('%s', '%s', '%s', '%d'));
    
    if ($insert !== FALSE) {
        $survey_register_output .= "<div id='survey-registration-success'>Survey Registration Success!</div>";
        $survey_register_output .= print_r($_POST, true);
        return TRUE;
    }
    else {
        $survey_register_output .= "<div id='survey-registration-failed'>Survey Registration Failed. ".
                                   "Try a different username.</div>";
        $survey_register_output .= print_r($_POST, true);
        return FALSE;
    }
}

/**
    Allows a shortcode to be created that will create a registration page. The shortcode is [survey-registration] 
**/
add_shortcode('survey-registration','survey_registration');
function survey_registration($atts, $content=null) {
    global $survey_register_output;
    
    echo <<<HTML
    {$survey_register_output}
    <h3>Login / Registration Page</h3> 
    <form id='survey-registration' action='{$_SERVER['REQUEST_URI']}' method='post'>
        <div id='survey-r'>
            <div id='survey-username'>
                <span>Username:</span> <input type='text' name='survey_username-r' maxlength='30' />
            </div>
            <div id='survey-password'>
                <span>Password:</span> <input type='password' name='survey_password-r' maxlength='20' />
            </div>
            <div id='survey-fullname'>
               <span>Full Name:</span> <input type='text' name='survey_fullname-r' maxlength='50' />
            </div>
            <input type='hidden' name='survey_physician-r' value='1' />
            <div id='survey-submit-r'><input type='submit' value='Submit' name='survey_submit-r' /></div>
        </div>
    </form>
    <form id='survey-login' action='{$_SERVER['REQUEST_URI']}' method='post'>
        <div id='survey-l'>
            <div id='survey-username-l'>
                <span>Username:</span> <input type='text' name='survey_username-l' maxlength='30' />
            </div>
            <div id='survey-password-l'>
                <span>Password:</span> <input type='password' name='survey_password-l' maxlength='20' />
            </div>
            <div id='survey-submit'><input type='submit' value='Submit' name='survey_submit-l' /></div>
        </div>
    </form>
HTML;
}