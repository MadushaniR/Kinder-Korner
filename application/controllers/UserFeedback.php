<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserFeedback extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Method to update user feedback on a quiz
    public function updateFeedback($userID, $quizID, $action)
    {
        // Load UserFeedbackModel and call updateFeedback method
        $this->load->model('UserFeedbackModel');
        return $this->UserFeedbackModel->updateFeedback($userID, $quizID, $action);
    }

    // Method to get the count of likes and dislikes for a quiz
    public function getLikesDislikesCount($quizID)
    {
        // Load UserFeedbackModel and call getLikesDislikesCount method
        $this->load->model('UserFeedbackModel');
        return $this->UserFeedbackModel->getLikesDislikesCount($quizID);
    }

    // Method to update quiz details based on user feedback
    public function updateQuizDetails($quizID)
    {
        // Load UserFeedbackModel and call updateQuizDetails method
        $this->load->model('UserFeedbackModel');
        return $this->UserFeedbackModel->updateQuizDetails($quizID);
    }
}
?>
