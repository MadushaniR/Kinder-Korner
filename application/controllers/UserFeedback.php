<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class UserFeedback extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('UserFeedbackModel');
    }

    // Method to update user feedback on a quiz
    public function updateFeedback_post()
    {
        $userID = $this->post('userID');
        $quizID = $this->post('quizID');
        $action = $this->post('action');

        $result = $this->UserFeedbackModel->updateFeedback($userID, $quizID, $action);
        if ($result) {
            $this->response([
                'success' => true,
                'totalLikes' => $result['totalLikes'],
                'totalDislikes' => $result['totalDislikes']
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'success' => false,
                'message' => 'Failed to update feedback'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
