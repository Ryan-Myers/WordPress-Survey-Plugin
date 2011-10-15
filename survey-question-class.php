<?php
class question {
    const truefalse = 1;
    const multichoice = 2;
    const dropdown = 3;
    const multiselect = 4;
    const shortanswer = 5;
    const longanswer = 6;
    const multichoiceother = 7;
    const multiselectother = 8;
    public $id = FALSE;
    public $question;
    public $questiontype;
    public $ordernum;
    public $hidden = 0;
    public $answers = array();
    public $answer = NULL;
    
    public function __construct($id, $type = 0, $questiontext = "", $ordernum = 0) {
        global $wpdb;
        
        //Find a question based the passed id.
        if ($id !== FALSE) {
            $query = "SELECT id, question, questiontype, ordernum, hidden ".
                     "FROM {$wpdb->prefix}survey_questions WHERE id = %d";
            $row = $wpdb->get_row($wpdb->prepare($query, $id));
            
            if ($row !== FALSE) {
                $this->id = $row->id;
                $this->question = $row->question;
                $this->questiontype = $row->questiontype;
                $this->ordernum = $row->ordernum;
                $this->hidden = $row->hidden;
                
                $query = "SELECT id, answer, ordernum ".
                         "FROM {$wpdb->prefix}survey_answers WHERE question = %d AND hidden = 0 ORDER BY ordernum";
                $this->answers = $wpdb->get_results($wpdb->prepare($query, $this->id), OBJECT_K);
            }
        }
        //If false was passed for id, instead build a new question
        else {
            $insert = $wpdb->insert($wpdb->prefix.'survey_questions', 
                                    array('question'=>$questiontext, 'questiontype'=>$type, 'ordernum'=>$ordernum), 
                                    array('%s', '%d', '%d'));
            
            //Set the id of this survey to the id of the last inserted row.
            $this->id = $insert ? $wpdb->insert_id : FALSE;
            
            if ($this->id !== FALSE) {
                $this->question = $questiontext;
                $this->questiontype = $type;
                $this->ordernum = $ordernum;
            }
            else {
                throw new Exception('Could not create question!');
            }
        }
    }
    
    public function add_answer($answer, $ordernum = FALSE) {
        global $wpdb;
        
        //Don't add answers for certain questions
        if ($this->questiontype !== self::truefalse && 
            $this->questiontype !== self::shortanswer && 
            $this->questiontype !== self::longanswer) {
            
            if ($ordernum === FALSE) {
                //Select the highest order number and add one, to append this question.
                $query = "SELECT MAX(ordernum)+1 AS ordernum ".
                         "FROM {$wpdb->prefix}survey_answers WHERE question = %d AND hidden = 0";
                $ordernum = $wpdb->get_var($wpdb->prepare($query, $this->id));
            }
            
            $insert = $wpdb->insert($wpdb->prefix.'survey_answers', 
                                    array('question'=>$this->id, 'answer'=>$answer, 'ordernum'=>$ordernum), 
                                    array('%d', '%s', '%d'));
            
            //Upon successful creation of an answer, recreate the list of answers in this object.
            //It's being recreated to keep the order proper.
            if ($insert) {
                $query = "SELECT id, answer, ordernum ".
                         "FROM {$wpdb->prefix}survey_answers WHERE question = %d AND hidden = 0 ORDER BY ordernum";
                $this->answers = $wpdb->get_results($wpdb->prepare($query, $this->id), OBJECT_K);
            }
        }
        else {
            //throw new Exception('Cannot add answers to this type of question');
        }
    }
    
    public function get_question() {
        $output = "<div class='question-container'>\n".
                  "  <div class='question'>{$this->question}</div>\n".
                  "  <div class='answer-container'>\n";
        
        switch ($this->questiontype) {
            case self::truefalse:
                $output .= "    <div class='tf-answer'>\n".
                           "      <input type='radio' name='tf-{$this->id}' value='true' /> True<br />\n".
                           "      <input type='radio' name='tf-{$this->id}' value='false' /> False\n".
                           "    </div>\n";
            break;
            
            case self::multichoice:
                $output .= "    <div class='mc-answer'>\n";
                
                foreach ($this->answers as $answer) {
                    $output .= "      <input type='radio' name='mc-{$this->id}' value='{$answer->id}' /> ".
                               "{$answer->answer}<br />\n";
                }
                
                $output .= "    </div>\n";
            break;
            
            case self::dropdown:
                $output .= "    <div class='dd-answer'>\n".
                           "      <select name='dd-{$this->id}'>\n";
                foreach ($this->answers as $answer) {
                    $output .= "        <option value='{$answer->id}'>{$answer->answer}</option>\n";
                }
                $output .= "      </select>\n".
                           "    </div>\n";
            break;
            
            case self::multiselect:
                $output .= "    <div class='ms-answer'>\n";
                
                foreach ($this->answers as $answer) {
                    $output .= "      <input type='checkbox' name='ms-{$this->id}[]' value='{$answer->id}' /> ".
                               "{$answer->answer}<br />\n";
                }
                
                $output .= "    </div>\n";
            break;
            
            case self::shortanswer:
                $output .= "    <div class='sa-answer'>\n".
                           "        <input type='text' name='sa-{$this->id}' />\n".
                           "    </div>\n";
            break;
                        
            case self::longanswer:
                $output .= "    <div class='la-answer'>\n".
                           "        <textarea cols='80' rows='10' name='la-{$this->id}'></textarea>\n".
                           "    </div>\n";
            break;
            
            case self::multichoiceother:
                $output .= "    <div class='mco-answer'>\n";
                
                foreach ($this->answers as $answer) {
                    $output .= "      <input type='radio' name='mco-{$this->id}' value='{$answer->id}' /> ".
                               "{$answer->answer}<br />\n";
                }
                
                $output .= "      <input type='radio' name='mco-{$this->id}' value='other' /> ".
                           "      Other (Please Specify): <input type='text' name='mco-other-{$this->id}' />\n";
                
                $output .= "    </div>\n";
            break;
            
            case self::multiselectother:
                $output .= "    <div class='mso-answer'>\n";
                
                foreach ($this->answers as $answer) {
                     $output .= "      <input type='checkbox' name='mso-{$this->id}[]' value='{$answer->id}' /> ".
                                "{$answer->answer}<br />\n";
                }
                
                $output .= "      <input type='checkbox' name='mso-{$this->id}[]' value='other' /> ".
                           "      Other (Please Specify): <input type='text' name='mso-other-{$this->id}' />\n";
                
                $output .= "    </div>\n";
            break;
            
            default:
                throw new Exception("Question type of {$this->questiontype} not supported!");
        }
        
        //Close the answer-container and the question-container
        $output .= "  </div>\n".
                   "</div>\n";
        
        return $output;
    }
    
    public function get_answer() {
        switch ($this->questiontype) {
            case self::truefalse:
                if (isset($_POST["tf-{$this->id}"])) {
                    //Sets the answer to true/false as a string.
                    $this->answer = $_POST["tf-{$this->id}"];
                }
            break;
            
            case self::multichoice:
                if (isset($_POST["mc-{$this->id}"])) { 
                    //Sets the answer to the answer text.
                    $this->answer = $this->answers[$_POST["mc-{$this->id}"]]->answer;
                }
            break;
            
            case self::dropdown:
                if (isset($_POST["dd-{$this->id}"])) { 
                    //Sets the answer to the answer text.
                    $this->answer = $this->answers[$_POST["dd-{$this->id}"]]->answer;
                }
            break;
            
            case self::multiselect:
                if (isset($_POST["ms-{$this->id}"])) { 
                    $answers = $_POST["ms-{$this->id}"];
                    
                    //Sets the answer to an array of the answers.
                    $this->answer = array();
                    foreach ($answers as $answer) {
                        $this->answer[] = $this->answers[$answer]->answer;
                    }
                }
            break;
            
            case self::shortanswer:
                if (isset($_POST["sa-{$this->id}"])) {
                    //Set the answer to the short answer text.
                    $this->answer = $_POST["sa-{$this->id}"];
                }
            break;
            
            case self::longanswer:
                if (isset($_POST["la-{$this->id}"])) {
                    //Set the answer to the long answer text.
                    $this->answer = $_POST["la-{$this->id}"];
                }
            break;
            
            case self::multichoiceother:
                if (isset($_POST["mco-{$this->id}"])) {
                    $answer = $_POST["mco-{$this->id}"];
                    
                    if ($answer != "other") {
                        //Treat like a normal multiple choice answer.
                        $this->answer = $this->answers[$answer]->answer;
                    }
                    else {
                        //If it's the other selection, grab the text from the other box as the answer.
                        $this->answer = $_POST["mco-other-{$this->id}"];
                    }
                }
            break;
            
            case self::multiselectother:
                if (isset($_POST["mso-{$this->id}"])) {
                    $answers = $_POST["mso-{$this->id}"];
                    
                    //Sets the answer to an array of the answers.
                    $this->answer = array();
                    foreach ($answers as $answer) {
                        if ($answer != "other") {
                            //Treat like a normal multiple selection answer.
                            $this->answer[] = $this->answers[$answer]->answer;
                        }
                        else {
                            //If it's the other selection, grab the text from the other box as the answer.
                            $this->answer[] = $_POST["mso-other-{$this->id}"];
                        }
                    }
                }
            break;
        }
        
        return $this->answer;
    }
}