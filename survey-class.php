<?php
class survey {
    public $id = FALSE;
    public $name;
    public $questions = "";
    public $qobjects = array(); //array of question objects
    public $questionsperpage;
    
    public function __construct($id, $name = "", $questionsperpage = 10) {
        global $wpdb;
        
        //Find a survey based the passed id.
        if ($id !== FALSE) {   
            $row = $wpdb->get_row($wpdb->prepare("SELECT id, name, questions, questionsperpage FROM {$wpdb->prefix}survey WHERE id = %d", $id));
            
            if ($row !== FALSE) {
                $this->id = $row->id;
                $this->name = $row->question;
                $this->questions = $row->questions;
                $this->questionsperpage = $row->questionsperpage;
                
                //Transform the comma seperated list of questions id's into an array, and then create a question object for each one.
                $questions = explode(',', $this->questions);
                foreach ($questions as $question_id) {
                    $this->qobjects[$question_id] = new question($question_id);
                }
            }
        }
        //If false was passed for id, instead build a new survey
        else {
            $insert = $wpdb->insert($wpdb->prefix.'survey', array('name'=>$name, 'questionsperpage'=>$questionsperpage), array('%s', '%d'));
            
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
    
    public function add_question($type, $questiontext = "") {
        //If you want to add a question by id, then use add_qobject(new question($id))
        add_qobject(new question(FALSE, $type, $questiontext));
    }
    
    public function add_qobject($qobject) {
        //Add this object to the array indexed by the question id.
        $this->qobjects[$qobject->id] = $qobject;
        
        //Add the question ids to the questions string.
        $this->add_question_id($qobject->id);
    }
    
    private function add_question_id($question_id) {
        global $wpdb;
        
        //Assume if questions has any characters it must be correct, and have an id in there.
        if (strlen($this->questions) > 0) {
            //Take the current comma seperated list of questions and place them in an array.
            $questions = explode(',', $this->questions);
            
            //Add the new question id to the list.
            $questions[] = $question_id;
            
            //Then bring them all together again seperated by commas. Also makes sure to only use unique instances of each question.
            $this->questions = implode(',', array_unique($questions));
        }
        else {
            //If questions is empty, just add this one as the only question.
            $this->questions = $question_id;
        }
        
        //Update the database with this new list of questions
        $wpdb->update($wpdb->prefix.'survey', array('questions'=>$this->questions), array('id'=>$this->id), array('%s'), array('%d'));
    }
}