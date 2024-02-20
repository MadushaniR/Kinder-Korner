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
}
