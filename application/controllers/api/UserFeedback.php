<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class UserFeedback extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->model('UserFeedbackModel'); // Load the model
    }

    // Endpoint to update user feedback on a quiz
    public function updateFeedback_put($userID, $quizID, $action) {
        // Call updateFeedback method from UserFeedbackModel
        $result = $this->UserFeedbackModel->updateFeedback($userID, $quizID, $action);
        
        if ($result) {
            $this->response(array('success' => true, 'message' => 'User feedback updated successfully'), 200);
        } else {
            $this->response(array('success' => false, 'message' => 'Failed to update user feedback'), 400);
        }
    }

    // Endpoint to get the count of likes and dislikes for a quiz
    public function likesDislikesCount_get($quizID) {
        // Call getLikesDislikesCount method from UserFeedbackModel
        $count = $this->UserFeedbackModel->getLikesDislikesCount($quizID);
        
        if ($count !== null) {
            $this->response(array('success' => true, 'likes_dislikes_count' => $count), 200);
        } else {
            $this->response(array('success' => false, 'message' => 'Failed to retrieve likes and dislikes count'), 400);
        }
    }

    // Endpoint to update quiz details based on user feedback
    public function updateQuizDetails_put($quizID) {
        // Call updateQuizDetails method from UserFeedbackModel
        $result = $this->UserFeedbackModel->updateQuizDetails($quizID);
        
        if ($result) {
            $this->response(array('success' => true, 'message' => 'Quiz details updated based on user feedback'), 200);
        } else {
            $this->response(array('success' => false, 'message' => 'Failed to update quiz details based on user feedback'), 400);
        }
    }
}
