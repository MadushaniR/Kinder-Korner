<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizDisplay extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getQuestionDetails($questionID)
    {
        $this->load->model('QuizDisplayModel');
        $questionDetails = $this->QuizDisplayModel->getQuestionDetails($questionID);
        echo json_encode($questionDetails);
    }

    public function quizdisplay()
    {
        $user_name = $this->session->userdata('user_name');
        $userID = $this->session->userdata('userID');
        $quizID = $this->input->get('quizID');

        if (!$quizID) {
            redirect(base_url());
        }

        // $this->load->model('quizmodel');
        $this->load->model('UserAnswerModel');
        $this->load->model('QuizDisplayModel');

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

            // Store user answers in the database
            $this->UserAnswerModel->storeUserAnswers($userAnswers);

            redirect('Results/resultdisplay?quizID=' . $quizID);
        }

        $this->data['questions'] = $this->QuizDisplayModel->getQuestions($quizID);
        $this->data['quizID'] = $quizID;
        $this->data['user_name'] = $user_name;
        $this->data['userID'] = $userID;

        // Initialize the currentPage variable
        $this->data['currentPage'] = 0;
        $this->load->model('AuthModel');
        $this->load->view('Quiz/play_quiz', $this->data);
    }

    public function updateFeedback($userID, $quizID, $action)
    {
        // Check if the user already has feedback for the quiz
        $existingFeedback = $this->db
            ->where('userID', $userID)
            ->where('quizID', $quizID)
            ->get('feedback')
            ->row();

        if ($existingFeedback) {
            // User already has feedback for this quiz, do not update
            return $this->getLikesDislikesCount($quizID);
        }

        // If no existing feedback, proceed to update
        $data = array(
            'userID' => $userID,
            'quizID' => $quizID,
            'isLike' => ($action == 'like') ? TRUE : FALSE,
            'isDislike' => ($action == 'dislike') ? TRUE : FALSE,
        );

        $this->db->replace('feedback', $data);

        // Update total likes and dislikes for the quiz in quizdetails table
        $this->updateQuizDetails($quizID);

        // Return updated likes and dislikes count
        return $this->getLikesDislikesCount($quizID);
    }

    public function getLikesDislikesCount($quizID)
    {
        $this->db->select('SUM(isLike) as totalLikes, SUM(isDislike) as totalDislikes');
        $this->db->where('quizID', $quizID);
        $query = $this->db->get('feedback');

        return $query->row_array();
    }


    public function updateQuizDetails($quizID)
    {
        // Calculate total likes and dislikes for the quiz
        $totalLikesDislikes = $this->getLikesDislikesCount($quizID);

        // Update quizdetails table with the calculated values
        $this->db
            ->where('quizID', $quizID)
            ->update('quizdetails', $totalLikesDislikes);

        // Check for database errors
        $db_error = $this->db->error();
        if (!empty($db_error['code'])) {
            // Database error occurred
            log_message('error', 'Database error: ' . $db_error['code'] . ' ' . $db_error['message']);
        } else {
            // Check if the update was successful
            if ($this->db->affected_rows() > 0) {
                // Quiz details updated successfully!
            } else {
                log_message('error', 'No rows affected. Error updating quiz details!');
            }
        }
    }
}
