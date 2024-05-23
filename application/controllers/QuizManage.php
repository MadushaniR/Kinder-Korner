<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

use chriskacerguis\RestServer\RestController;

class QuizManage extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('QuizManagementModel');
        $this->load->library('session');
    }

    public function quize_manage_get()
    {
        $quizData = $this->QuizManagementModel->getQuizData();
        $this->load->view('Quiz/create_quiz', ['quizData' => $quizData]);
    }

    public function quiz_data_get()
    {
        $quizData = $this->QuizManagementModel->getQuizData();
        $this->response($quizData, 200);
    }

    public function create_quiz_post()
    {
        $quizName = $this->input->post('quizName');
        $quizDescription = $this->input->post('quizDescription');
        $userID = $this->session->userdata('userID');

        $quizData = [
            'quizName' => $quizName,
            'quizDescription' => $quizDescription,
            'userID' => $userID
        ];

        $questions = $this->input->post('questionText');
        $correctAnswers = $this->input->post('correctAnswer');
        $options1 = $this->input->post('option1');
        $options2 = $this->input->post('option2');
        $options3 = $this->input->post('option3');
        $options4 = $this->input->post('option4');

        $questionsData = [];

        for ($i = 0; $i < count($questions); $i++) {
            $questionsData[] = [
                'questionText' => $questions[$i],
                'correctAnswer' => $correctAnswers[$i],
                'option1' => $options1[$i],
                'option2' => $options2[$i],
                'option3' => $options3[$i],
                'option4' => $options4[$i]
            ];
        }

        $result = $this->QuizManagementModel->create_quiz($quizData, $questionsData);

        if ($result) {
            $this->response(['message' => 'Quiz created successfully'], 200);
        } else {
            $this->response(['message' => 'Quiz creation failed: Quiz name already exists'], 400);
        }
    }

    public function delete_question_post()
    {
        $questionID = $this->input->post('questionID');
        $result = $this->QuizManagementModel->delete_question($questionID);

        if ($result) {
            $this->response(['message' => 'Question deleted successfully'], 200);
        } else {
            $this->response(['message' => 'Failed to delete question'], 400);
        }
    }

    public function get_question_details_post()
    {
        $questionID = $this->input->post('questionID');
        $questionDetails = $this->QuizManagementModel->get_question_details($questionID);

        if ($questionDetails) {
            $this->response(['success' => true, 'data' => $questionDetails], 200);
        } else {
            $this->response(['success' => false, 'message' => 'Failed to fetch question details.'], 400);
        }
    }


    // Method to update question details
    public function update_question_post()
    {
        $this->load->model('QuizManagementModel');

        // Retrieve edited data from the POST request
        $editedData = $this->input->post();

        // Extract the question ID from the POST data
        $questionID = $editedData['questionID'];

        // Update the question details in the database
        $this->QuizManagementModel->updateQuestionDetails($questionID, $editedData);

        // Send a success response
        $this->response(['success' => true], 200);
    }
}
