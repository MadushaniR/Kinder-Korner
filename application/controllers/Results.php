<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Results extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('ResultsModel');
    }

    // Method to display the score after completing a quiz
    public function score()
    {
        // Retrieve correctAnswers, totalQuestions, user name, and quiz ID from the URL query parameters
        $correctAnswers = $this->input->get('correctAnswers');
        $totalQuestions = $this->input->get('totalQuestions');
        $user_name = $this->session->userdata('user_name');
        $quizID = $this->input->get('quizID');

         // Retrieve the current user's total score
         $userID = $this->session->userdata('userID');
         $totalScore = $this->ResultsModel->getUserTotalScore($userID);

        // Load the view and pass the score, total questions, user name, and quiz ID as data
        $this->load->view('Quiz/score', array(
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
            'user_name' => $user_name,
            'quizID' => $quizID, 
            'totalScore' => $totalScore 
        ));
    }

    // Method to display the quiz results
    public function resultdisplay()
    {
        // Fetch user session data and quizID from URL parameter
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->input->get('quizID');

        // Redirect to home page if no quizID is provided
        if (!$quizID) {
            redirect(base_url());
        }

        // Retrieve and prepare quiz results data
        $this->data['questions'] = $this->ResultsModel->getResults($quizID);
        $this->data['quizID'] = $quizID;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;

        $totalQuestions = count($this->data['questions']);
        $correctAnswers = 0;

        // Iterate through questions to calculate correct answers and update user answers
        foreach ($this->data['questions'] as $row) {
            $userAnswerText = '';
            $questionID = $row->questionID;

            // Check if user has selected an answer
            if (isset($_POST['selectedOption'][$questionID])) {
                $userAnswerText = $_POST['selectedOption'][$questionID];
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
        $this->load->view('Quiz/results_display', $this->data);
    }
}
?>
