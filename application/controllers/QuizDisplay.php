<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizDisplay extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getQuestionDetails($questionID)
    {
        $this->load->model('QuizDisplayModel');
        $questionDetails = $this->QuizDisplayModel->getQuestionDetails($questionID);
        echo json_encode($questionDetails);
    }

    public function quizdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->input->get('quizID');

        if (!$quizID) {
            redirect(base_url());
        }

        // $this->load->model('quizmodel');
        $this->load->model('UserAnswerModel');
        $this->load->model('QuizDisplayModel');

        if ($this->input->post()) {
            $userAnswers = array();
            foreach ($this->input->post('questionID') as $questionID) {
                $selectedOption = $this->input->post('selectedOption')[$questionID];
                $userAnswers[] = array(
                    'userID' => $userID,
                    'quizID' => $quizID,
                    'questionID' => $questionID,
                    'selectedOption' => $selectedOption,
                );
            }

            // Store user answers in the database
            $this->UserAnswerModel->storeUserAnswers($userAnswers);

            redirect('Results/resultdisplay?quizID=' . $quizID);
        }

        $this->data['questions'] = $this->QuizDisplayModel->getQuestions($quizID);
        $this->data['quizID'] = $quizID;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;

        // Initialize the currentPage variable
        $this->data['currentPage'] = 0;
        $this->load->model('AuthModel');
        $this->load->view('Quiz/play_quiz', $this->data);
    }
    
}
