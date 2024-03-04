<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Results extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function resultdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->input->get('quizID');
        if (!$quizID) {
            redirect(base_url());
        }

        $this->load->model('ResultsModel');
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
