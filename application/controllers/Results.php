<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class Results extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ResultsModel');
        $this->load->library('session');
    }

    public function resultdisplay_get()
    {
        $quizID = $this->get('quizID');
        $selectedAnswersJson = $this->get('selectedAnswers');
        $selectedAnswers = json_decode($selectedAnswersJson, true);

        if (!$quizID) {
            $this->response(['status' => false, 'error' => 'Quiz ID not provided'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        if (!$selectedAnswers) {
            $this->response(['status' => false, 'error' => 'Selected answers not provided or invalid'], RestController::HTTP_BAD_REQUEST);
            return;
        }

        $userID = $this->session->userdata('userID');

        // Store user answers
        $this->ResultsModel->storeUserAnswers($selectedAnswers, $userID, $quizID);

        // Get results data
        $resultsData = $this->ResultsModel->getResultsDetailsById($quizID);

        if ($resultsData) {
            $this->load->view('results', ['quizID' => $quizID, 'quizData' => $resultsData, 'selectedAnswers' => $selectedAnswers]);
        } else {
            $this->response(['status' => false, 'error' => 'Quiz not found'], RestController::HTTP_NOT_FOUND);
        }
    }


    public function score_get()
    {
        $userID = $this->session->userdata('userID');
        $totalStars = $this->ResultsModel->getTotalStars($userID);

        $score = $this->input->get('score');
        $totalQuestions = $this->input->get('totalQuestions');
        $quizID = $this->input->get('quizID');
        $this->load->view('Quiz/score', ['score' => $score, 'totalQuestions' => $totalQuestions, 'quizID' => $quizID, 'totalStars' => $totalStars]);
    }
}
