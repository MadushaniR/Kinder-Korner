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

        // $this->load->model('quizmodel');
        $this->load->model('ResultsModel');
        $this->data['questions'] = $this->ResultsModel->getResults($quizID);
        $this->data['quizID'] = $quizID;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;
        $this->load->model('AuthModel');
        $this->load->view('Quiz/results_display', $this->data);
    }
}
