<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizManage extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    // Method to create a new quiz
    public function createquiz()
    {
        // Load QuizDisplayModel
        $this->load->model('QuizDisplayModel');

        // Process form submission
        if ($this->input->post()) {
            // Retrieve form data
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

            // Determine quizID
            if ($existingQuiz) {
                // Use the existing quizID
                $quizID = $existingQuiz->quizID;
            } else {
                // Insert new quiz details
                $maxQuizNumber = $this->db->select_max('quizNumber')->get('quizdetails')->row()->quizNumber;
                $quizNumber = $maxQuizNumber + 1;

                $data = array(
                    'quizName' => $quizName,
                    'quizDescription' => $quizDescription,
                    'userID' => $this->session->userdata('userID'),
                    'quizNumber' => $quizNumber
                );

                $this->db->insert('quizdetails', $data);
                $quizID = $this->db->insert_id();
            }

            // Insert questions and options
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

            // Set flashdata and redirect
            $this->session->set_flashdata('success', 'Quiz created successfully!');
            redirect('QuizManage/createquiz');
        }

        // Retrieve quiz details for display
        $this->data['quizzes'] = $this->QuizDisplayModel->getQuizDetails();

        // Load the create quiz view
        $this->load->view('Quiz/create_quiz', $this->data);
    }

    // Method to delete a question
    public function deleteQuestion($questionID)
    {
        // Load QuizManagementModel
        $this->load->model('QuizManagementModel');
        // Call deleteQuestion method
        $this->QuizManagementModel->deleteQuestion($questionID);
        // You can redirect to the same page or send a success message if needed
    }

    // Method to update question details
    public function updateQuestion($questionID)
    {
        // Load QuizManagementModel
        $this->load->model('QuizManagementModel');

        // Retrieve edited data from the POST request
        $editedData = $this->input->post();

        // Update the question details in the database
        $this->QuizManagementModel->updateQuestionDetails($questionID, $editedData);

        // Send a success response
        echo json_encode(['success' => true]);
    }
}
