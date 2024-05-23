<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizDisplayModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getQuestions($quizID)
    {
        $this->db->select('questions.questionID, questions.questionText, options.optionID, options.option1, options.option2, options.option3, options.option4, questions.isDeleted');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.quizID', $quizID);
        $this->db->where('questions.isDeleted', 0);

        $query = $this->db->get();
        return $query->result();
    }

    // public function getQuizDetails()
    // {
    //     $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, questions.questionID, questions.questionText, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer, questions.isDeleted');
    //     $this->db->from('quizdetails');
    //     $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
    //     $this->db->join('questions', 'quizdetails.quizID = questions.quizID', 'left');
    //     $this->db->join('options', 'questions.questionID = options.questionID', 'left');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    public function getQuizDetails()
    {
        $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, 
                            SUM(IF(feedback.isLike = 1, 1, 0)) AS totalLikes,
                            SUM(IF(feedback.isDislike = 1, 1, 0)) AS totalDislikes');
        $this->db->from('quizdetails');
        $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
        $this->db->join('feedback', 'quizdetails.quizID = feedback.quizID', 'left');
        $this->db->group_by('quizdetails.quizID');
        $query = $this->db->get();
        return $query->result();
    }



    public function getQuestionDetails($questionID)
    {
        $this->db->select('questions.questionID, questions.questionText, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.questionID', $questionID);
        $this->db->where('questions.isDeleted', 0);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function getQuizDetailsById($quizID)
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
}
