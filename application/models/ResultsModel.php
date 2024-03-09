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

    public function updateUserAnswers($userID, $quizID, $questionID, $selectedOption)
    {
        $data = array(
            'userID' => $userID,
            'quizID' => $quizID,  // Assuming quizID is the correct column name in the 'useranswer' table
            'questionID' => $questionID,
            'selectedOption' => $selectedOption,
        );
    
        // Check if the user has already answered the question for this quiz
        $existingAnswer = $this->db->get_where('useranswer', array('userID' => $userID, 'quizID' => $quizID, 'questionID' => $questionID))->row();
    
        if ($existingAnswer) {
            // Update existing answer
            $this->db->where('answerID', $existingAnswer->answerID);
            $this->db->update('useranswer', $data);
        } else {
            // Insert a new answer
            $this->db->insert('useranswer', $data);
        }
    }

    public function updateQuizResult($userID, $quizID, $score, $totalQuestions)
    {
        $data = array(
            'userID' => $userID,
            'quizID' => $quizID,
            'score' => $score,
            'totalQuestions' => $totalQuestions,
        );

        $existingResult = $this->db->get_where('results', array('userID' => $userID, 'quizID' => $quizID))->row();

        if ($existingResult) {
            $this->db->where('resultsID', $existingResult->resultsID);
            $this->db->update('results', $data);
        } else {
            $this->db->insert('results', $data);
        }
    }
}
?>
