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
    public $dependentquestion;
    public $dependentanswer;
    public $hidden = 0;
    public $answers = array();
    public $answer = NULL;
    
    public function __construct($id, $type = 0, $questiontext = "", $depquestion = -1, $depanswer = -1, $ordernum = 1) {
        global $wpdb;
        
        //Find a question based the passed id.
        if ($id !== FALSE) {
            $query = "SELECT id, question, questiontype, ordernum, dependentquestion, dependentanswer, hidden ".
                     "FROM {$wpdb->prefix}survey_questions WHERE id = %d";
            $row = $wpdb->get_row($wpdb->prepare($query, $id));
            
            if ($row !== FALSE && $row !== NULL) {
                $this->id = $row->id;
                $this->question = $row->question;
                $this->questiontype = $row->questiontype;
                $this->ordernum = $row->ordernum;
                $this->dependentquestion = $row->dependentquestion;
                $this->dependentanswer = $row->dependentanswer;
                $this->hidden = $row->hidden;
                
                $query = "SELECT id, answer, ordernum ".
                         "FROM {$wpdb->prefix}survey_answers WHERE question = %d AND hidden = 0 ORDER BY ordernum";
                $this->answers = $wpdb->get_results($wpdb->prepare($query, $this->id), OBJECT_K);
                
                $this->answer = $this->set_answer();
            }
            else {
                throw new Exception("Could not find question with passed ID of $id");
            }
        }
        //If false was passed for id, instead build a new question
        else {
            $insert = $wpdb->insert($wpdb->prefix.'survey_questions', 
                                    array('question'=>$questiontext, 'questiontype'=>$type, 'ordernum'=>$ordernum,
                                          'dependentquestion'=>$depquestion, 'dependentanswer'=>$depanswer), 
                                    array('%s', '%d', '%d', '%d', '%d'));
            
            //Set the id of this survey to the id of the last inserted row.
            $this->id = $insert ? $wpdb->insert_id : FALSE;
            
            if ($this->id !== FALSE) {
                $this->question = $questiontext;
                $this->questiontype = $type;
                $this->dependentquestion = $depquestion;
                $this->dependentanswer = $depanswer;
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
                
                //If there isn't any order numbers existing yet, this is the first so default it to 1.
                if ($ordernum === NULL || $ordernum < 1) $ordernum = 1;
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
    
    public function edit_question($question) {
        global $wpdb;
        
        $this->question = $question;
        $wpdb->update($wpdb->prefix.'survey_questions', array('question'=>$question), 
                    array('id'=>$this->id), array('%s'), array('%d'));
    }
    
    public function edit_type($qtype) {
        global $wpdb;
        
        $this->questiontype = $qtype;
        $wpdb->update($wpdb->prefix.'survey_questions', array('questiontype'=>$qtype), 
                    array('id'=>$this->id), array('%s'), array('%d'));
    }
    
    public function edit_answer($answer_id, $answer) {
        global $wpdb;
        
        if (isset($this->answers[$answer_id])) {
            $this->answers[$answer_id]->answer = $answer;
            
            $wpdb->update($wpdb->prefix.'survey_answers', array('answer'=>$answer), 
                          array('id'=>$answer_id), array('%s'), array('%d'));
        }
    }
    
    public function edit_dependency($question_id, $answer_id) {
        global $wpdb;
        
        $this->dependentquestion = $question_id;
        $this->dependentanswer = $answer_id;
        
        $wpdb->update($wpdb->prefix.'survey_questions', 
                    array('dependentquestion'=>$question_id, 'dependentanswer'=>$answer_id),
                    array('id'=>$this->id), array('%d', '%d'), array('%d'));
    }
    
    public function get_question() {
        global $wpdb;
        
        //Logic to determine if the question should default to being hidden based on it being dependent on another.
        if ($this->dependentquestion != "-1") {
            $query = "SELECT questiontype FROM {$wpdb->prefix}survey_questions WHERE id=%d";
            $qtype = $wpdb->get_var($wpdb->prepare($query, $this->dependentquestion));
            
            if ($qtype !== NULL && $qtype != self::shortanswer && $qtype != self::longanswer) {
                $query = "SELECT answer FROM {$wpdb->prefix}survey_user_answers WHERE user=%d AND question=%d";
                $answer = $wpdb->get_var($wpdb->prepare($query, get_survey_user_session(), $this->dependentquestion));
                
                if ($answer !== NULL && $qtype != self::truefalse) {
                    //If the answer contains multiple answers, this will gather them together into an array.
                    $answers = explode(';; ', $answer);
                    
                    foreach ($answers as $answer) {
                        $query = "SELECT id FROM {$wpdb->prefix}survey_answers WHERE question=%d AND answer=%s";
                        $answer_id = $wpdb->get_var($wpdb->prepare($query, $this->dependentquestion, $answer));
                        
                        if ($answer_id !== NULL) {
                            if ($answer_id == $this->dependentanswer) {
                                //Don't hide this question. It correctly matches the dependent answer.
                                $style = "";
                            }
                        }
                    }
                }
                elseif ($answer !== NULL && $qtype == self::truefalse) {
                    if ($answer == "true" && $this->dependentanswer == "1") {
                        $style = "";
                    }
                    elseif ($answer == "false" && $this->dependentanswer == "0") {
                        $style = "";
                    }
                }
            }
        }
        
        //Hide the question by default if it's a dependent one. But not if it's already been set to nothing above.
        if (!isset($style) && $this->dependentquestion != "-1") {
            $style = "style='display:none'";
        }
        else {
            $style = "";
        }
        
        $output = "<div class='question-container' $style>\n".
                  "  <div class='question'>{$this->question}</div>\n".
                  "  <div class='answer-container'>\n";
        
        switch ($this->questiontype) {
            case self::truefalse:
                //Automatically select the answer if it's already been answered.
                $true = ($this->answer == "true") ? "checked='checked'" : "";
                $false = ($this->answer == "false") ? "checked='checked'" : "";
                
                $output .= "    <div class='tf-answer'>\n".
                           "      <input type='radio' name='tf-{$this->id}' value='true' ".
                                  "onclick='select_answer({$this->id}, 1)' $true /> True<br />\n".
                           "      <input type='radio' name='tf-{$this->id}' value='false' ".
                                  "onclick='select_answer({$this->id}, 0)' $false /> False\n".
                           "    </div>\n";
            break;
            
            case self::multichoice:
                $output .= "    <div class='mc-answer'>\n";
                
                foreach ($this->answers as $answer) {
                    //Select the answer that was previously chosen if it was.
                    $selected = ($answer->answer == $this->answer) ? "checked='checked'" : "";
                    
                    $output .= "      <input type='radio' name='mc-{$this->id}' value='{$answer->id}' ".
                               "onclick='select_answer({$this->id}, {$answer->id})' $selected /> ".
                               "{$answer->answer}<br />\n";
                }
                
                $output .= "    </div>\n";
            break;
            
            case self::dropdown:
                $output .= "    <div class='dd-answer'>\n".
                           "      <select name='dd-{$this->id}' ".
                                  "onchange='select_answer({$this->id}, this.selectedindex)'>\n";
                
                foreach ($this->answers as $answer) {
                    //Select the answer that was previously chosen if it was.
                    $selected = ($answer->answer == $this->answer) ? "selected='selected'" : "";
                    
                    $output .= "        <option value='{$answer->id}' $selected>{$answer->answer}</option>\n";
                }
                
                $output .= "      </select>\n".
                           "    </div>\n";
            break;
            
            case self::multiselect:
                $output .= "    <div class='ms-answer'>\n";
                
                foreach ($this->answers as $answer) {
                    //Select the answer that was previously chosen if it was. Checks every part of the array.
                    $checked = (in_array($answer->answer, $this->answer)) ? "checked='checked'" : "";
                    
                    $output .= "      <input type='checkbox' name='ms-{$this->id}[]' value='{$answer->id}' ".
                                        "onclick='select_answer({$this->id}, {$answer->id})' $checked/> ".
                               "{$answer->answer}<br />\n";
                }
                
                $output .= "    </div>\n";
            break;
            
            case self::shortanswer:                
                $output .= "    <div class='sa-answer'>\n".
                           "        <input type='text' name='sa-{$this->id}' value='{$this->answer}' />\n".
                           "    </div>\n";
            break;
                        
            case self::longanswer:
                $output .= "    <div class='la-answer'>\n".
                           "        <textarea cols='80' rows='10' name='la-{$this->id}'>{$this->answer}</textarea>\n".
                           "    </div>\n";
            break;
            
            case self::multichoiceother:
                $output .= "    <div class='mco-answer'>\n";
                
                $select_other = " ";
                $selected = "";
                $value = "";
                
                foreach ($this->answers as $answer) {
                    if ($answer->answer == $this->answer) {
                        $selected = "checked='checked'";
                        $select_other = "";
                        $value = "";
                    }
                    elseif (!empty($this->answer) && !empty($select_other)) {
                        $selected = "";
                        $select_other = "checked='checked'";
                        $value = "value='{$this->answer}'";
                    }
                    
                    $output .= "      <input type='radio' name='mco-{$this->id}' value='{$answer->id}' ".
                                        "onclick='select_answer({$this->id}, {$answer->id})' $selected /> ".
                               "{$answer->answer}<br />\n";
                }
                                
                $output .= "      <input type='radio' name='mco-{$this->id}' value='other' $select_other /> ".
                           "      Other (Please Specify): <input type='text' name='mco-other-{$this->id}' $value />\n";
                
                $output .= "    </div>\n";
            break;
            
            case self::multiselectother:
                $output .= "    <div class='mso-answer'>\n";
                
                $other_array = array();
                foreach ($this->answers as $answer) {
                    //Select the answer that was previously chosen if it was. Checks every part of the array.
                    if (in_array($answer->answer, $this->answer)) {
                        $checked = "checked='checked'";
                        $other_array[] = $answer->answer;
                    }
                    else {
                        $checked = "";
                    }
                    
                    $output .= "   <input type='checkbox' name='mso-{$this->id}[]' value='{$answer->id}' ".
                                    "onclick='select_answer({$this->id}, {$answer->id})' $checked /> ".
                               "{$answer->answer}<br />\n";
                }
                
                //Grabs the $other_array which has the value of every regular answer, and gets the difference
                //between it, and the $this->answer array. This should give the other answer if there is one.
                list($key, $other_val) = each(array_diff($this->answer, $other_array));
                $other_select = (!empty($other_val)) ? "checked='checked'" : "";
                
                $output .= "      <input type='checkbox' name='mso-{$this->id}[]' value='other' $other_select /> ".
                           "      Other (Please Specify): \n".
                           "      <input type='text' name='mso-other-{$this->id}' value='{$other_val}' />\n";
                
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
    
    public function get_answer($posted) {
        switch ($this->questiontype) {
            case self::truefalse:
                if (isset($posted["tf-{$this->id}"])) {
                    //Sets the answer to true/false as a string.
                    $this->answer = $posted["tf-{$this->id}"];
                }
            break;
            
            case self::multichoice:
                if (isset($posted["mc-{$this->id}"])) { 
                    //Sets the answer to the answer text.
                    $this->answer = $this->answers[$posted["mc-{$this->id}"]]->answer;
                }
            break;
            
            case self::dropdown:
                if (isset($posted["dd-{$this->id}"])) { 
                    //Sets the answer to the answer text.
                    $this->answer = $this->answers[$posted["dd-{$this->id}"]]->answer;
                }
            break;
            
            case self::multiselect:
                if (isset($posted["ms-{$this->id}"])) { 
                    $answers = $posted["ms-{$this->id}"];
                    
                    //Sets the answer to an array of the answers.
                    $this->answer = array();
                    foreach ($answers as $answer) {
                        $this->answer[] = $this->answers[$answer]->answer;
                    }
                }
            break;
            
            case self::shortanswer:
                if (isset($posted["sa-{$this->id}"])) {
                    //Set the answer to the short answer text.
                    $this->answer = $posted["sa-{$this->id}"];
                }
            break;
            
            case self::longanswer:
                if (isset($posted["la-{$this->id}"])) {
                    //Set the answer to the long answer text.
                    $this->answer = $posted["la-{$this->id}"];
                }
            break;
            
            case self::multichoiceother:
                if (isset($posted["mco-{$this->id}"])) {
                    $answer = $posted["mco-{$this->id}"];
                    
                    if ($answer != "other") {
                        //Treat like a normal multiple choice answer.
                        $this->answer = $this->answers[$answer]->answer;
                    }
                    else {
                        //If it's the other selection, grab the text from the other box as the answer.
                        $this->answer = $posted["mco-other-{$this->id}"];
                    }
                }
            break;
            
            case self::multiselectother:
                if (isset($posted["mso-{$this->id}"])) {
                    $answers = $posted["mso-{$this->id}"];
                    
                    //Sets the answer to an array of the answers.
                    $this->answer = array();
                    foreach ($answers as $answer) {
                        if ($answer != "other") {
                            //Treat like a normal multiple selection answer.
                            $this->answer[] = $this->answers[$answer]->answer;
                        }
                        else {
                            //If it's the other selection, grab the text from the other box as the answer.
                            $this->answer[] = $posted["mso-other-{$this->id}"];
                        }
                    }
                }
            break;
        }
        
        return $this->answer;
    }
    
    private function set_answer() {
        global $wpdb;
        
        $user_id = get_survey_user_session();
        
        $query = "SELECT answer FROM {$wpdb->prefix}survey_user_answers WHERE user=%d AND question=%d";
        $prepared = $wpdb->prepare($query, $user_id, $this->id);
        
        $answer = $wpdb->get_var($prepared);
        
        //Sets the answer to an array of the answers for multiple select questions
        if ($this->questiontype == self::multiselect || $this->questiontype == self::multiselectother) {
            $answer = explode(';; ', $answer);
        }
        
        return $answer;
    }
}