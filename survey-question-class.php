<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors',1);
require_once '../../../wp-config.php';
require_once 'survey-include.php';

class question {
    const truefalse = 1;
    const multichoice = 2;
    const dropdown = 3;
    public $id = false;
    public $question;
    public $questiontype;
    public $hidden = 0;
    public $answers = array();
    
    public function __construct($id, $type = 0, $questiontext = "") {
        global $wpdb;
        
        //Find a question based the passed id.
        if ($id !== FALSE) {
            $row = $wpdb->get_row("SELECT id, question, questiontype, hidden FROM {$wpdb->prefix}survey_questions WHERE id=$id");
            
            if ($row !== false) {
                $this->id = $row->id;
                $this->question = $row->question;
                $this->questiontype = $row->questiontype;
                $this->hidden = $row->hidden;
                $this->answers = $wpdb->get_results("SELECT id, question, answer, hidden FROM {$wpdb->prefix}survey_answers WHERE question={$this->id}", OBJECT_K);
            }
        }
        //If false was passed for id, instead build a new question
        else {
            $insert = $wpdb->insert($wpdb->prefix.'survey_questions', array('question'=>$questiontext, 'questiontype'=>$type), array('%s', '%d'));
            $this->id = $insert ? $wpdb->insert_id : false;
            $this->question = $questiontext;
            $this->questiontype = $type;
        }
    }
    
    public function add_answer($answer) {
        global $wpdb;
        
        //Don't add answers for True/False questions
        if ($this->type !== self::truefalse) {
            $insert = $wpdb->insert($wpdb->prefix.'survey_answers', array('question'=>$this->id, 'answer'=>$answer), array('%d', '%s'));
            
            //Upon successful creation of a question, add it to the list of answers.
            if ($insert) {
                $this->answers[$wpdb->insert_id] = $wpdb->get_row("SELECT id, question, answer, hidden FROM {$wpdb->prefix}survey_answers WHERE id={$wpdb->insert_id}");
            }
        }
        else {
            throw new Exception('Cannot add answers to a True/False question');
        }
    }
}

$question = new question(12);
debug($question);

$question->add_answer("Test Answer");
debug($question);

