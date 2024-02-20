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
        $quizNumber = $this->input->get('quizNumber');
        if (!$quizNumber) {
            redirect(base_url());
        }

        $this->load->model('quizmodel');
        $this->data['questions'] = $this->quizmodel->getQuestions($quizNumber);
        $this->data['quizNumber'] = $quizNumber;
        $this->data['user_name'] = $user_name;
        $this->load->model('auth_model');
        $this->load->view('Quiz/play_quiz', $this->data);
    }
 
    public function resultdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $quizNumber = $this->input->get('quizNumber');

        $this->data['checks'] = array(
            'ques1' => $this->input->post('quizid1'),
            'ques2' => $this->input->post('quizid2'),
            'ques3' => $this->input->post('quizid3'),
            'ques4' => $this->input->post('quizid4'),
            'ques5' => $this->input->post('quizid5'),
            'ques6' => $this->input->post('quizid6'),
            'ques7' => $this->input->post('quizid7'),
        );

        $this->load->model('quizmodel');
        $this->data['results'] = $this->quizmodel->getQuestions($quizNumber);
        $this->data['quizNumber'] = $quizNumber;
        $this->data['user_name'] = $user_name;
        $this->load->model('auth_model');
        $this->load->view('Quiz/results_display', $this->data);
    }

    public function createquiz() {
        // Load any necessary libraries or models
        $this->load->model('quizmodel');

        // Check if the form is submitted
        if ($this->input->post()) {
            // Process form data and insert a new quiz into the database

            // Get form data
            $question = $this->input->post('question');
            $choice1 = $this->input->post('choice1');
            $choice2 = $this->input->post('choice2');
            $choice3 = $this->input->post('choice3');
            $answer = $this->input->post('answer');
            $quizNumber = $this->input->post('quizNumber');

            // Validate form data (you may add more validation as needed)

            // Insert data into the database using CodeIgniter's query builder
            $data = array(
                'question' => $question,
                'choice1' => $choice1,
                'choice2' => $choice2,
                'choice3' => $choice3,
                'answer' => $answer,
                'quizNumber' => $quizNumber
            );

            $this->db->insert('quiz', $data);

            // Check for database errors
            if ($this->db->affected_rows() > 0) {
                // Set a flash message for success
                $this->session->set_flashdata('success', 'Quiz created successfully!');
            } else {
                // Set a flash message for error
                $this->session->set_flashdata('error', 'Failed to create quiz. Please try again.');
                
                // Debugging: Display database error (if any)
                echo "Database Error: " . $this->db->error()['message'];
            }

            // Redirect to Auth/main
            redirect('Auth/main');
        }

        // Load the view for creating a new quiz
        $this->load->view('Quiz/create_quiz');
    }
}

