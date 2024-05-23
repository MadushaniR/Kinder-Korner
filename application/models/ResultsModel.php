<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ResultsModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Existing method to get results details by quiz ID
    public function getResultsDetailsById($quizID)
    {
        $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, questions.questionID, questions.questionText, options.optionID, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer, questions.isDeleted');
        $this->db->from('quizdetails');
        $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
        $this->db->join('questions', 'quizdetails.quizID = questions.quizID', 'left');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('quizdetails.quizID', $quizID);
        $this->db->where('questions.isDeleted', 0);
        $query = $this->db->get();
        return $query->result();
    }

    // New method to store user answers
    public function storeUserAnswers($answers, $userID, $quizID)
    {
        $correctAnswers = 0; // Initialize correct answers count
        foreach ($answers as $answer) {
            $data = [
                'questionID' => $answer['questionID'],
                'selectedOption' => $answer['answer'],
                'userID' => $userID,
                'quizID' => $quizID,
            ];
            $this->db->insert('useranswer', $data);

            // Check if the selected answer matches the correct answer
            $question = $this->db->get_where('questions', ['questionID' => $answer['questionID']])->row();
            if ($question && $answer['answer'] == $question->correctAnswer) {
                $correctAnswers++; // Increment correct answers count
            }
        }

        // Calculate score (correct answers count)
        $totalQuestions = count($answers);
        $score = $correctAnswers;

        // Insert or update result in the results table
        $resultData = [
            'userID' => $userID,
            'quizID' => $quizID,
            'score' => $score,
            'totalQuestions' => $totalQuestions
        ];
        $this->db->where('userID', $userID);
        $this->db->where('quizID', $quizID);
        $existingResult = $this->db->get('results')->row();
        if ($existingResult) {
            // Update existing result
            $this->db->where('resultsID', $existingResult->resultsID);
            $this->db->update('results', $resultData);
        } else {
            // Insert new result
            $this->db->insert('results', $resultData);
        }
    }

    public function getTotalStars($userID)
    {
        $this->db->select_sum('score', 'totalStars');
        $this->db->where('userID', $userID);
        $query = $this->db->get('results');
        return $query->row()->totalStars;
    }
}
