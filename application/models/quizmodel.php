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

public function getQuizDetails()
{
    $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, questions.questionID, questions.questionText, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer');
    $this->db->from('quizdetails');
    $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
    $this->db->join('questions', 'quizdetails.quizID = questions.quizID', 'left');
    $this->db->join('options', 'questions.questionID = options.questionID', 'left');

    $query = $this->db->get();

    return $query->result();
}


public function deleteQuestion($questionID)
{
    // Get the quizID associated with the question
    $quizID = $this->db->select('quizID')->from('questions')->where('questionID', $questionID)->get()->row()->quizID;

    // Delete options first
    $this->db->where('questionID', $questionID);
    $this->db->delete('options');

    // Now, delete the question
    $this->db->where('questionID', $questionID);
    $this->db->delete('questions');

    // Check if there are no more questions for the same quiz
    $remainingQuestions = $this->db->where('quizID', $quizID)->get('questions')->num_rows();

    // If no more questions, delete the quizdetails row
    if ($remainingQuestions == 0) {
        $this->db->where('quizID', $quizID);
        $this->db->delete('quizdetails');
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


    public function getQuestionDetails($questionID)
    {
        $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, questions.questionID, questions.questionText, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer');
        $this->db->from('quizdetails');
        $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
        $this->db->join('questions', 'quizdetails.quizID = questions.quizID', 'left');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.questionID', $questionID);

        $query = $this->db->get();

        return $query->row_array();
    }

    public function updateQuestion($questionID, $data)
    {
        $this->db->where('questionID', $questionID);
        $this->db->update('questions', $data);

        // Check for errors
        $error = $this->db->error();

        return ($error['code'] === 0);
    }
}
