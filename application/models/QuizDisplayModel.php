<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizDisplayModel extends CI_Model
{
    // Method to get questions for a specific quiz
    public function getQuestions($quizID)
    {
        $this->db->select('questions.questionID, questions.questionText, options.optionID, options.option1, options.option2, options.option3, options.option4, questions.isDeleted');
        $this->db->from('questions');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.quizID', $quizID);

        $query = $this->db->get();

        return $query->result();
    }

    // Method to get details of all quizzes
    public function getQuizDetails()
    {
        $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, questions.questionID, questions.questionText, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer, questions.isDeleted');
        $this->db->from('quizdetails');
        $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
        $this->db->join('questions', 'quizdetails.quizID = questions.quizID', 'left');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    // Method to get details of a specific question
    public function getQuestionDetails($questionID)
    {
        $this->db->select('quizdetails.quizID, quizdetails.quizName, quizdetails.quizDescription, quizdetails.quizNumber, quizdetails.userID, users.username, questions.questionID, questions.questionText, options.option1, options.option2, options.option3, options.option4, questions.correctAnswer, questions.isDeleted');
        $this->db->from('quizdetails');
        $this->db->join('users', 'quizdetails.userID = users.userID', 'left');
        $this->db->join('questions', 'quizdetails.quizID = questions.quizID', 'left');
        $this->db->join('options', 'questions.questionID = options.questionID', 'left');
        $this->db->where('questions.questionID', $questionID);

        $query = $this->db->get();

        return $query->row_array();
    }
}
