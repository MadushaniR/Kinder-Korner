<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class QuizDisplay extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->model('QuizDisplayModel'); 
    }

    // Endpoint to get question details
    public function question_get($questionID) {
        $questionDetails = $this->QuizDisplayModel->getQuestionDetails($questionID);
        if ($questionDetails) {
            $this->response($questionDetails, 200); // Respond with question details
        } else {
            $this->response(array('error' => 'Question not found'), 404); 
        }
    }

    // Endpoint to display the quiz
    public function quiz_get() {
        // Fetch quiz ID from query parameter
        $quizID = $this->get('quizID');

        // Redirect to home page if no quizID is provided
        if (!$quizID) {
            $this->response(array('error' => 'Quiz ID not provided'), 400); 
        }

        // Fetch quiz questions
        $questions = $this->QuizDisplayModel->getQuestions($quizID);

        // Respond with quiz questions
        if ($questions) {
            $this->response($questions, 200);
        } else {
            $this->response(array('error' => 'Quiz questions not found'), 404); 
        }
    }
}
