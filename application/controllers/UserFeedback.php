<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserFeedback extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function updateFeedback($userID, $quizID, $action)
    {
        $this->load->model('UserFeedbackModel');
        return $this->UserFeedbackModel->updateFeedback($userID, $quizID, $action);
    }

    public function getLikesDislikesCount($quizID)
    {
        $this->load->model('UserFeedbackModel');
        return $this->UserFeedbackModel->getLikesDislikesCount($quizID);
    }

    public function updateQuizDetails($quizID)
    {
        $this->load->model('UserFeedbackModel');
        return $this->UserFeedbackModel->updateQuizDetails($quizID);
    }
    
}
