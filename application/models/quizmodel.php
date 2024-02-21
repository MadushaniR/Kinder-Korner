<?php
defined('BASEPATH') or exit('No direct script access allowed');
class quizmodel extends CI_Model
{
    public function getQuestions($quizNumber)
    {
        $this->db->select('questions.questionID, questions.questionText, options.optionID, options.option1, options.option2, options.option3, options.option4');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.quizID', $quizNumber);

        $query = $this->db->get();

        return $query->result();
    }

    public function storeUserAnswer($data)
    {
        $this->db->insert('useranswer', $data);
    }
    public function getUserAnswers($userID, $quizNumber)
    {
        $this->db->select('questionID, selectedOption');
        $this->db->from('useranswer');
        $this->db->where('userID', $userID);
        $this->db->where('quizNumber', $quizNumber);

        $query = $this->db->get();

        return $query->result();
    }
    public function getResults($quizNumber)
    {
        $this->db->select('questions.questionID, questions.questionText, questions.correctAnswer, options.optionID, options.option1, options.option2, options.option3, options.option4');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.quizID', $quizNumber);

        $query = $this->db->get();

        return $query->result();
    }
}
