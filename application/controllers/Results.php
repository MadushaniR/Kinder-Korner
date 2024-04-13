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
//     public function score()
// {
//     $this->load->view('Quiz/score');
// }
// public function score()
// {
//     // Retrieve score from the query parameter
//     $correctAnswers = $this->input->get('correctAnswers');
    
//     // Get total questions from the query parameter
//     $totalQuestions = $this->input->get('totalQuestions');
    
//     // Load the view and pass the score and total questions as data
//     $this->load->view('Quiz/score', array('correctAnswers' => $correctAnswers, 'totalQuestions' => $totalQuestions));
// }
// public function score()
// {
//     // Retrieve correctAnswers, totalQuestions, and user name from the URL query parameters
//     $correctAnswers = $this->input->get('correctAnswers');
//     $totalQuestions = $this->input->get('totalQuestions');
//     $user_name = $this->session->userdata('user_name');
//     $this->data['user_name'] = $user_name;

//     // Load the view and pass the score, total questions, and user name as data
//     $this->load->view('Quiz/score', array('correctAnswers' => $correctAnswers, 'totalQuestions' => $totalQuestions, 'userName' => $user_name));
// }

public function score()
{
    // Retrieve correctAnswers, totalQuestions, and user name from the URL query parameters
    $correctAnswers = $this->input->get('correctAnswers');
    $totalQuestions = $this->input->get('totalQuestions');
    $user_name = $this->session->userdata('user_name');

    // Load the view and pass the score, total questions, and user name as data
    $this->load->view('Quiz/score', array('correctAnswers' => $correctAnswers, 'totalQuestions' => $totalQuestions, 'user_name' => $user_name));
}

    public function resultdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->input->get('quizID');
        if (!$quizID) {
            redirect(base_url());
        }

        $this->data['questions'] = $this->ResultsModel->getResults($quizID);
        $this->data['quizID'] = $quizID;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;

        $totalQuestions = count($this->data['questions']);
        $correctAnswers = 0;

        foreach ($this->data['questions'] as $row) {
            $userAnswerText = '';
            $questionID = $row->questionID;

            if (isset($_POST['selectedOption'][$questionID])) {
                $userAnswerText = $_POST['selectedOption'][$questionID];
                $this->ResultsModel->updateUserAnswers($userID, $quizID, $questionID, $userAnswerText);
            }

            $isCorrect = ($userAnswerText == $row->correctAnswer);

            if ($isCorrect) {
                $correctAnswers++;
            }
        }

        $this->ResultsModel->updateQuizResult($userID, $quizID, $correctAnswers, $totalQuestions);

        $this->load->model('AuthModel');
        $this->load->view('Quiz/results_display', $this->data);
    }
}
?>
