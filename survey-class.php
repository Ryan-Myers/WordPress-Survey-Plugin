<?php
class survey {
    public $id = FALSE;
    public $name;
    public $questions = "";
    public $qobjects = array(); //array of question objects
    public $questionsperpage;
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
                //and then create a question object for each one.
                $questions = explode(',', $this->questions);
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
	
	public function output_survey() {
		$output = "<form method='post' action='{$_SERVER["REQUEST_URI"]}' id='survey-form'>\n";
		
		foreach ($this->qobjects as $question) {
			$output .= $question->get_question();
		}
        
		$output .= "<input type='hidden' name='survey-id' value='{$this->id}' />\n";
		$output .= "<input type='submit' id='survey-submit' value='Submit' />\n</form>";
		
		echo $output;
	}
	
	public function get_answers() {	
		foreach ($this->qobjects as $question) {
			$this->answers[$question->id] = $question->get_answer();
		}
		
		return $this->answers;
	}
}