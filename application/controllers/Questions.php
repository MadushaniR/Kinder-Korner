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


    // public function createquiz()
    // {
    //     $this->load->model('quizmodel');

    //     if ($this->input->post()) {
    //         $quizName = $this->input->post('quizName');
    //         $quizDescription = $this->input->post('quizDescription');
    //         $questions = $this->input->post('question');
    //         $choices1 = $this->input->post('choice1');
    //         $choices2 = $this->input->post('choice2');
    //         $choices3 = $this->input->post('choice3');
    //         $choices4 = $this->input->post('choice4');
    //         $answers = $this->input->post('answer');

    //         $data = array(
    //             'quizName' => $quizName,
    //             'quizDescription' => $quizDescription,
    //             'userID' => $this->session->userdata('userID')
    //         );

    //         $this->db->insert('quizdetails', $data);
    //         $quizID = $this->db->insert_id();

    //         foreach ($questions as $index => $question) {
    //             $questionData = array(
    //                 'quizID' => $quizID,
    //                 'questionText' => $question,
    //                 'correctAnswer' => $answers[$index]
    //             );

    //             $this->db->insert('questions', $questionData);
    //             $questionID = $this->db->insert_id();

    //             $optionsData = array(
    //                 'questionID' => $questionID,
    //                 'option1' => $choices1[$index],
    //                 'option2' => $choices2[$index],
    //                 'option3' => $choices3[$index],
    //                 'option4' => $choices4[$index]
    //             );

    //             $this->db->insert('options', $optionsData);
    //         }

    //         $this->session->set_flashdata('success', 'Quiz created successfully!');
    //         redirect('Auth/main');
    //     }

    //     $this->load->view('Quiz/create_quiz');
    // }
    public function createquiz()
{
    $this->load->model('quizmodel');

    if ($this->input->post()) {
        $quizName = $this->input->post('quizName');
        $quizDescription = $this->input->post('quizDescription');
        $questions = $this->input->post('question');
        $choices1 = $this->input->post('choice1');
        $choices2 = $this->input->post('choice2');
        $choices3 = $this->input->post('choice3');
        $choices4 = $this->input->post('choice4');
        $answers = $this->input->post('answer');

        // Check if the quizName already exists
        $existingQuiz = $this->db->get_where('quizdetails', array('quizName' => $quizName))->row();

        if ($existingQuiz) {
            // Use the existing quizID
            $quizID = $existingQuiz->quizID;
        } else {
            // Insert new quiz details
            $data = array(
                'quizName' => $quizName,
                'quizDescription' => $quizDescription,
                'userID' => $this->session->userdata('userID')
            );

            $this->db->insert('quizdetails', $data);
            $quizID = $this->db->insert_id();
        }

        // Get the maximum quizNumber and increment it
        $maxQuizNumber = $this->db->select_max('quizNumber')->get('quizdetails')->row()->quizNumber;
        $quizNumber = $maxQuizNumber + 1;

        // Update the quizNumber for the current quiz
        $this->db->update('quizdetails', array('quizNumber' => $quizNumber), array('quizID' => $quizID));

        foreach ($questions as $index => $question) {
            $questionData = array(
                'quizID' => $quizID,
                'questionText' => $question,
                'correctAnswer' => $answers[$index]
            );

            $this->db->insert('questions', $questionData);
            $questionID = $this->db->insert_id();

            $optionsData = array(
                'questionID' => $questionID,
                'option1' => $choices1[$index],
                'option2' => $choices2[$index],
                'option3' => $choices3[$index],
                'option4' => $choices4[$index]
            );

            $this->db->insert('options', $optionsData);
        }

        $this->session->set_flashdata('success', 'Quiz created successfully!');
        redirect('Auth/main');
    }

    $this->load->view('Quiz/create_quiz');
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
