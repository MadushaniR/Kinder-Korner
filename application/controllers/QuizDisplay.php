<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizDisplay extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Method to fetch question details via AJAX
    public function getQuestionDetails($questionID)
    {
        $this->load->model('QuizDisplayModel');
        // Get question details from QuizDisplayModel and encode as JSON
        $questionDetails = $this->QuizDisplayModel->getQuestionDetails($questionID);
        echo json_encode($questionDetails);
    }

    // Method to display the quiz
    public function quizdisplay()
    {
        // Fetch user session data
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        // Get quizID from URL parameter
        $quizID = $this->input->get('quizID');

        // Redirect to home page if no quizID is provided
        if (!$quizID) {
            redirect(base_url());
        }

        // Load QuizDisplayModel
        $this->load->model('QuizDisplayModel');

        // Process form submission
        if ($this->input->post()) {
            $userAnswers = array();
            // Iterate through submitted answers
            foreach ($this->input->post('questionID') as $questionID) {
                $selectedOption = $this->input->post('selectedOption')[$questionID];
                $userAnswers[] = array(
                    'userID' => $userID,
                    'quizID' => $quizID,
                    'questionID' => $questionID,
                    'selectedOption' => $selectedOption,
                );
            }
            redirect('Results/resultdisplay?quizID=' . $quizID);
        }

        // Fetch quiz questions
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
