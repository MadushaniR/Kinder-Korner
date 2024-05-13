<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
use chriskacerguis\RestServer\RestController;

class Results extends RestController {
    public function __construct() {
        parent::__construct();
        $this->load->model('ResultsModel'); // Load the model
    }

    // Endpoint to display the score after completing a quiz
    public function score_get() {
        // Retrieve correctAnswers, totalQuestions, user name, and quiz ID from the URL query parameters
        $correctAnswers = $this->get('correctAnswers');
        $totalQuestions = $this->get('totalQuestions');
        $user_name = $this->session->userdata('user_name');
        $quizID = $this->get('quizID');

        // Load the view and pass the score, total questions, user name, and quiz ID as data
        $this->load->view('Quiz/score', array(
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
            'user_name' => $user_name,
            'quizID' => $quizID // Pass the quiz ID to the score view
        ));
    }

    // Endpoint to display the quiz results
    public function resultdisplay_get() {
        // Fetch user session data and quizID from URL parameter
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->get('quizID');

        // Redirect to home page if no quizID is provided
        if (!$quizID) {
            $this->response(array('success' => false, 'message' => 'No quizID provided'), 400);
        }

        // Retrieve and prepare quiz results data
        $questions = $this->ResultsModel->getResults($quizID);
        $totalQuestions = count($questions);
        $correctAnswers = 0;

        // Iterate through questions to calculate correct answers and update user answers
        foreach ($questions as $row) {
            $userAnswerText = '';
            $questionID = $row->questionID;

            // Check if user has selected an answer
            if ($this->input->get('selectedOption') !== null) {
                $userAnswerText = $this->input->get('selectedOption');
                // Update user answers in the database
                $this->ResultsModel->updateUserAnswers($userID, $quizID, $questionID, $userAnswerText);
            }

            // Check if user's answer is correct
            $isCorrect = ($userAnswerText == $row->correctAnswer);

            // Increment correctAnswers count if the answer is correct
            if ($isCorrect) {
                $correctAnswers++;
            }
        }

        // Update quiz result in the database
        $this->ResultsModel->updateQuizResult($userID, $quizID, $correctAnswers, $totalQuestions);

        // Load AuthModel and display results view
        $this->load->model('AuthModel');
        $this->response(array(
            'success' => true,
            'message' => 'Quiz results displayed successfully',
            'data' => array(
                'questions' => $questions,
                'quizID' => $quizID,
                'user_name' => $user_name,
                'userID' => $userID
            )
        ), 200);
    }
}
