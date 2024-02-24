<?php
defined('BASEPATH') or exit('No direct script access allowed');
class quizmodel extends CI_Model
{
    public function getQuestions($quizID)
    {
        $this->db->select('questions.questionID, questions.questionText, options.optionID, options.option1, options.option2, options.option3, options.option4');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.quizID', $quizID);

        $query = $this->db->get();

        return $query->result();
    }
//     public function storeUserAnswers($userAnswers)
// {
//     $this->db->insert_batch('useranswer', $userAnswers);

//     // Add this line for debugging
//     echo $this->db->last_query();
// }

public function storeUserAnswers($userAnswers)
{
    $this->db->insert_batch('useranswer', $userAnswers);

    // Check for errors
    $error = $this->db->error();

    if ($error['code'] !== 0) {
        // Handle the error (e.g., log it, display an error message)
        echo 'Database Error: ' . $error['message'];
        // Print the last query for debugging purposes
        echo 'Last Query: ' . $this->db->last_query();
    } else {
        // Successful insertion
        echo 'User answers stored successfully!';
    }
}

    
    

    public function getUserAnswers($userID, $quizID)
    {
        $this->db->select('questionID, selectedOption');
        $this->db->from('useranswer');
        $this->db->where('userID', $userID);
        $this->db->where('quizID', $quizID);

        $query = $this->db->get();

        return $query->result();
    }

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
