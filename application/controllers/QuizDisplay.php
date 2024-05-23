<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class QuizDisplay extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('QuizDisplayModel');
        $this->load->library('session');
    }

    public function quizes_get()
    {

        $userID = $this->session->userdata('userID');
        $quizDetails = $this->QuizDisplayModel->getQuizDetails();
        $data['quizDetails'] = $quizDetails;
        $data['userID'] = $userID;
        $this->load->view('Quiz/quizes', $data);
    }

    // Method to fetch question details via AJAX
    public function question_get($questionID)
    {
        if (!$questionID) {
            $this->response(null, 400);
        }

        $questionDetails = $this->QuizDisplayModel->getQuestionDetails($questionID);
        if ($questionDetails) {
            $this->response($questionDetails, 200);
        } else {
            $this->response(null, 404);
        }
    }

    // Method to display the quiz
    public function quizdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->input->get('quizID');

        if (!$quizID) {
            redirect(base_url());
        }

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
            // redirect('Results/resultdisplay?quizID=' . $quizID);
        }

        $this->data['questions'] = $this->QuizDisplayModel->getQuestions($quizID);
        $this->data['quizID'] = $quizID;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;
        $this->data['currentPage'] = 0;

        // $this->load->view('Quiz/play_quiz', $this->data);
    }

    // Method to fetch quiz questions with options for a given quiz ID and render view
    public function quizplay_get()
    {
        $quizID = $this->get('quizID');
        if (!$quizID) {
            $this->response(['status' => false, 'error' => 'Quiz ID not provided'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $quizData = $this->QuizDisplayModel->getQuizDetailsById($quizID);

        if ($quizData) {
            $this->load->view('Quiz/play_quiz', ['quizData' => $quizData]);
        } else {
            $this->response(['status' => false, 'error' => 'Quiz not found'], RestController::HTTP_NOT_FOUND);
        }
    }
}
