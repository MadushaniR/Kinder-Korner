<?php
defined('BASEPATH') or exit('No direct script access allowed');
class ResultsModel extends CI_Model
{
    public function getResults($quizID)
    {
        $this->db->select('questions.questionID, questions.questionText, questions.correctAnswer, options.optionID, options.option1, options.option2, options.option3, options.option4');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.quizID', $quizID);
        $query = $this->db->get();
        return $query->result();
    }
}
