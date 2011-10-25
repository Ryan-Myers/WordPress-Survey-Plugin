<?php
class survey {
    public $id = FALSE;
    public $name;
    public $questions = "";
    public $qobjects = array(); //array of question objects
    public $questionsperpage;
    public $pages;
    public $answers = array();
    
    public function __construct($id, $name = "", $questionsperpage = 10) {
        global $wpdb;
        
        //Find a survey based the passed id.
        if ($id !== FALSE) {   
            $query = "SELECT id, name, questions, questionsperpage FROM {$wpdb->prefix}survey WHERE id = %d";
            $row = $wpdb->get_row($wpdb->prepare($query, $id));
            
            if ($row !== NULL) {
                $this->id = $row->id;
                $this->name = $row->name;
                $this->questions = $row->questions;
                $this->questionsperpage = $row->questionsperpage;
                
                //Transform the comma seperated list of questions id's into an array, 
                $questions = explode(',', $this->questions);
                //Double check that it's not empty. Exploding nothing will create a single entry with an empty string.
                $questions = (!empty($questions)) ? $questions : array();
                
                //Get the number of pages by dividing the questions by questions per page and rounding up.
                $this->pages = ceil(count($questions) / $this->questionsperpage);
                
                //Create a question object for each question.
                foreach ($questions as $question_id) {
                    $this->add_qobject(new question($question_id));
                }
            }
            else {
                throw new Exception("Survey ID $id does not exist!");
            }
        }
        //If false was passed for id, instead build a new survey
        else {
            $insert = $wpdb->insert($wpdb->prefix.'survey', 
                                    array('name'=>$name, 'questionsperpage'=>$questionsperpage), 
                                    array('%s', '%d'));
            
            //Set the id of this survey to the id of the last inserted row.
            $this->id = $insert ? $wpdb->insert_id : FALSE;
            
            if ($this->id !== FALSE) {
                $this->name = $name;
                $this->questionsperpage = $questionsperpage;
            }
            else {
                throw new Exception('Survey could not be created!');
            }
        }
    }
    
    public function add_question($type, $questiontext = "", $ordernum = 0) {
        //If you want to add a question by id, then use add_qobject(new question($id))
        $qobject = $this->add_qobject(new question(FALSE, $type, $questiontext, $ordernum));
        
        return $qobject;
    }
    
    public function add_qobject($qobject) {
        //Add this object to the array indexed by the question order numbers
        if (!isset($this->qobjects[$qobject->ordernum])) {
            $this->qobjects[$qobject->ordernum] = $qobject;
        }
        else {
            //If the order number for this object already exists, just increment it by one and try again.
            $qobject->ordernum = $qobject->ordernum+1;
            $this->add_qobject($qobject);
            
            //Update the database with this new order number
            global $wpdb;
            $wpdb->update($wpdb->prefix.'survey_questions', array('ordernum'=>$qobject->ordernum), 
                      array('id'=>$qobject->id), array('%d'), array('%d'));
        }
        
        //Reorder the question by the array key to keep things in order for the output.
        ksort($this->qobjects);
        
        //Add the question ids to the questions string.
        $this->add_question_id($qobject->id);
        
        //Modify the number of pages by dividing the questions by questions per page and rounding up.
        $this->pages = ceil(count(explode(',', $this->questions)) / $this->questionsperpage);
        
        return $qobject;
    }
    
    private function add_question_id($question_id) {
        global $wpdb;
        
        //Assume if questions has any characters it must be correct, and have an id in there.
        if (strlen($this->questions) > 0) {
            //Take the current comma seperated list of questions and place them in an array.
            $questions = explode(',', $this->questions);
            
            //Add the new question id to the list.
            $questions[] = $question_id;
            
            //Then bring them all together again seperated by commas.
            //Also makes sure to only use unique instances of each question.
            $this->questions = implode(',', array_unique($questions));
        }
        else {
            //If questions is empty, just add this one as the only question.
            $this->questions = $question_id;
        }
        
        //Update the database with this new list of questions
        $wpdb->update($wpdb->prefix.'survey', array('questions'=>$this->questions), 
                      array('id'=>$this->id), array('%s'), array('%d'));
    }
    
    public function output_survey($page = 1) {
        $question_start = (($page * $this->questionsperpage) - $this->questionsperpage) + 1;
        $question_end = $question_start + $this->questionsperpage - 1 ;
        
        //Don't output anything if we're past the last page.
        if ($question_start > count($this->qobjects)) {
            return false;
        }
        
        //If the question end is greater than the number of questions, then it should only go to the last question.
        if ($question_end > count($this->qobjects)) {
            $question_end = count($this->qobjects);
        }
        
        $output = "<h3>$this->name</h3>\n";    
        $output .= "<form id='survey-form'>\n";
        
        for ($i = $question_start; $i <= $question_end; $i++) {
            $output .= $this->qobjects[$i]->get_question();
        }
                
        $output .= "<input type='hidden' name='survey-id' value='{$this->id}' />\n";
        $output .= "<input type='hidden' name='survey-page' value='{$page}' />\n";
        $output .= "<input type='submit' id='survey-submit' value='Submit' />\n</form>";
        
        return $output;
    }
    
    public function get_answers() {    
        foreach ($this->qobjects as $question) {
            $this->answers[$question->id] = $question->get_answer();
        }
        
        return $this->answers;
    }
}