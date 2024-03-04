<?php
defined('BASEPATH') or exit('No direct script access allowed');
class QuizDisplayModel extends CI_Model
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

//     public function updateFeedback($userID, $quizID, $action)
// {
//     $data = array(
//         'userID' => $userID,
//         'quizID' => $quizID,
//         'isLike' => ($action == 'like') ? TRUE : FALSE,
//         'isDislike' => ($action == 'dislike') ? TRUE : FALSE,
//     );

//     $this->db->replace('feedback', $data);

//     // Return updated likes and dislikes count
//     return $this->getLikesDislikesCount($quizID);
// }

// private function getLikesDislikesCount($quizID)
// {
//     $this->db->select('SUM(isLike) as likes, SUM(isDislike) as dislikes');
//     $this->db->where('quizID', $quizID);
//     $query = $this->db->get('feedback');

//     return $query->row_array();
// }
public function updateFeedback($userID, $quizID, $action)
{
    // Check if the user already has feedback for the quiz
    $existingFeedback = $this->db
        ->where('userID', $userID)
        ->where('quizID', $quizID)
        ->get('feedback')
        ->row();

    if ($existingFeedback) {
        // User already has feedback for this quiz, do not update
        return $this->getLikesDislikesCount($quizID);
    }

    // If no existing feedback, proceed to update
    $data = array(
        'userID' => $userID,
        'quizID' => $quizID,
        'isLike' => ($action == 'like') ? TRUE : FALSE,
        'isDislike' => ($action == 'dislike') ? TRUE : FALSE,
    );

    $this->db->replace('feedback', $data);

    // Return updated likes and dislikes count
    return $this->getLikesDislikesCount($quizID);
}

private function getLikesDislikesCount($quizID)
{
    $this->db->select('SUM(isLike) as likes, SUM(isDislike) as dislikes');
    $this->db->where('quizID', $quizID);
    $query = $this->db->get('feedback');

    return $query->row_array();
}
    
}
