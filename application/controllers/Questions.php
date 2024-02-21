<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Questions extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function quizdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizNumber = $this->input->get('quizNumber');
        if (!$quizNumber) {
            redirect(base_url());
        }

        $this->load->model('quizmodel');
        $this->data['questions'] = $this->quizmodel->getQuestions($quizNumber);
        $this->data['quizNumber'] = $quizNumber;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;
        $this->load->model('auth_model');
        $this->load->view('Quiz/play_quiz', $this->data);
    }


    public function createquiz()
    {
        // Load any necessary libraries or models
        $this->load->model('quizmodel');

        // Check if the form is submitted
        if ($this->input->post()) {
            // Process form data and insert a new quiz into the database

            // Get form data as arrays
            $questions = $this->input->post('questionText');
            $correctAnswers = $this->input->post('correctAnswer');
            $quizNumbers = $this->input->post('quizID');
            $option1 = $this->input->post('option1');
            $option2 = $this->input->post('option2');
            $option3 = $this->input->post('option3');
            $option4 = $this->input->post('option4');

            // Validate form data (you may add more validation as needed)

            // Insert data into the database using CodeIgniter's query builder
            foreach ($questions as $index => $question) {
                $data = array(
                    'quizID' => $quizNumbers[$index],
                    'questionText' => $question,
                    'correctAnswer' => $correctAnswers[$index],
                );

                $this->db->insert('questions', $data);

                // Get the last inserted question ID
                $questionID = $this->db->insert_id();

                // Insert options into the 'options' table
                $optionsData = array(
                    array('questionID' => $questionID, 'option1' => $option1[$index]),
                    array('questionID' => $questionID, 'option2' => $option2[$index]),
                    array('questionID' => $questionID, 'option3' => $option3[$index]),
                    array('questionID' => $questionID, 'option4' => $option4[$index]),
                );

                $this->db->insert_batch('options', $optionsData);
            }

            // Set a flash message for success
            $this->session->set_flashdata('success', 'Quiz created successfully!');

            // Redirect to the appropriate page after processing the form
            redirect('auth/main');
        }

        // Load the view for creating a new quiz
        $this->load->view('quiz/create_quiz');
    }

    public function resultdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizNumber = $this->input->get('quizNumber');

        if (!$quizNumber) {
            redirect(base_url());
        }

        $this->load->model('quizmodel');

        // Retrieve user's answers for the specified quizNumber
        $userAnswers = $this->quizmodel->getUserAnswers($userID, $quizNumber);

        // Retrieve questions and correct answers for the specified quizNumber
        $questions = $this->quizmodel->getResults($quizNumber);

        $data['user_name'] = $user_name;
        $data['userID'] = $userID;
        $data['quizNumber'] = $quizNumber;
        $data['userAnswers'] = $userAnswers;
        $data['questions'] = $questions;

        $this->load->view('Quiz/results_display', $data);
    }
}
