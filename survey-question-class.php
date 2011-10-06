<?php
class question {
    const truefalse = 1;
    const multichoice = 2;
    const dropdown = 3;
    const multiselect = 4;
    public $id = FALSE;
    public $question;
    public $questiontype;
    public $hidden = 0;
    public $answers = array();
    public $answer = NULL;
    
    public function __construct($id, $type = 0, $questiontext = "") {
        global $wpdb;
        
        //Find a question based the passed id.
        if ($id !== FALSE) {
            $row = $wpdb->get_row($wpdb->prepare("SELECT id, question, questiontype, hidden FROM {$wpdb->prefix}survey_questions WHERE id = %d", $id));
            
            if ($row !== FALSE) {
                $this->id = $row->id;
                $this->question = $row->question;
                $this->questiontype = $row->questiontype;
                $this->hidden = $row->hidden;
                $this->answers = $wpdb->get_results($wpdb->prepare("SELECT id, question, answer, hidden FROM {$wpdb->prefix}survey_answers WHERE question = %d", $this->id), OBJECT_K);
            }
        }
        //If false was passed for id, instead build a new question
        else {
            $insert = $wpdb->insert($wpdb->prefix.'survey_questions', array('question'=>$questiontext, 'questiontype'=>$type), array('%s', '%d'));
            
            //Set the id of this survey to the id of the last inserted row.
            $this->id = $insert ? $wpdb->insert_id : FALSE;
            
            if ($this->id !== FALSE) {
                $this->question = $questiontext;
                $this->questiontype = $type;
            }
            else {
                throw new Exception('Could not create question!');
            }
        }
    }
    
    public function add_answer($answer) {
        global $wpdb;
        
        //Don't add answers for True/False questions
        if ($this->type !== self::truefalse) {
            $insert = $wpdb->insert($wpdb->prefix.'survey_answers', array('question'=>$this->id, 'answer'=>$answer), array('%d', '%s'));
            
            //Upon successful creation of a question, add it to the list of answers.
            if ($insert) {
                $this->answers[$wpdb->insert_id] = $wpdb->get_row($wpdb->prepare("SELECT id, question, answer, hidden FROM {$wpdb->prefix}survey_answers WHERE id= = %d", $wpdb->insert_id));
            }
        }
        else {
            throw new Exception('Cannot add answers to a True/False question');
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
                    $output .= "      <input type='radio' name='mc-{$this->id}' value='{$answer->id}' /> {$answer->answer}<br />\n";
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
                    $output .= "      <input type='checkbox' name='ms-{$this->id}[]' value='{$answer->id}' /> {$answer->answer}<br />\n";
                }
                
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
        }
        
        return $this->answer;
    }
}