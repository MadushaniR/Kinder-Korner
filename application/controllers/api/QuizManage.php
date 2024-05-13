<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class QuizManage extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->model('QuizManagementModel'); 
    }

    // Endpoint to create a new quiz
    public function createquiz_post() {
        // Retrieve form data from POST request
        $quizName = $this->post('quizName');
        $quizDescription = $this->post('quizDescription');
        $questions = $this->post('questions');
        $options = $this->post('options');
        $answers = $this->post('answers');

        // Call the model method to handle quiz creation
        $result = $this->QuizManagementModel->createQuiz($quizName, $quizDescription, $questions, $options, $answers);

        // Check if quiz creation was successful
        if ($result) {
            $this->response(array('success' => true, 'message' => 'Quiz created successfully'), 200);
        } else {
            $this->response(array('success' => false, 'message' => 'Failed to create quiz'), 500);
        }
    }

    // Endpoint to delete a question
    public function deletequestion_delete($questionID) {
        // Call the model method to delete the question
        $result = $this->QuizManagementModel->deleteQuestion($questionID);

        // Check if deletion was successful
        if ($result) {
            $this->response(array('success' => true, 'message' => 'Question deleted successfully'), 200);
        } else {
            $this->response(array('success' => false, 'message' => 'Failed to delete question'), 500);
        }
    }

    // Endpoint to update question details
    public function updatequestion_put($questionID) {
        // Retrieve edited data from PUT request
        $editedData = $this->put();

        // Call the model method to update question details
        $result = $this->QuizManagementModel->updateQuestionDetails($questionID, $editedData);

        // Check if update was successful
        if ($result) {
            $this->response(array('success' => true, 'message' => 'Question updated successfully'), 200);
        } else {
            $this->response(array('success' => false, 'message' => 'Failed to update question'), 500);
        }
    }
}
