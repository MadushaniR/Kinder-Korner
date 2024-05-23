<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizManagementModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getQuizData()
    {
        $this->db->select('quizdetails.quizName, quizdetails.quizDescription, questions.questionID, questions.questionText, questions.correctAnswer, options.option1, options.option2, options.option3, options.option4');
        $this->db->from('quizdetails');
        $this->db->join('questions', 'questions.quizID = quizdetails.quizID');
        $this->db->join('options', 'options.questionID = questions.questionID');
        $this->db->where('questions.isDeleted', 0); // Only fetch non-deleted questions
        $query = $this->db->get();

        return $query->result_array();
    }

    public function create_quiz($quizData, $questionsData)
    {
        $this->db->where('quizName', $quizData['quizName']);
        $query = $this->db->get('quizdetails');

        if ($query->num_rows() > 0) {
            return false;
        }

        $this->db->select_max('quizNumber');
        $maxQuizNumberQuery = $this->db->get('quizdetails');
        $maxQuizNumber = $maxQuizNumberQuery->row()->quizNumber;
        $quizData['quizNumber'] = $maxQuizNumber + 1;

        $this->db->insert('quizdetails', $quizData);
        $quizID = $this->db->insert_id();

        foreach ($questionsData as $question) {
            $questionData = [
                'quizID' => $quizID,
                'questionText' => $question['questionText'],
                'correctAnswer' => $question['correctAnswer']
            ];
            $this->db->insert('questions', $questionData);
            $questionID = $this->db->insert_id();

            $optionsData = [
                'questionID' => $questionID,
                'option1' => $question['option1'],
                'option2' => $question['option2'],
                'option3' => $question['option3'],
                'option4' => $question['option4']
            ];
            $this->db->insert('options', $optionsData);
        }

        return true;
    }

    public function delete_question($questionID)
    {
        $this->db->where('questionID', $questionID);
        return $this->db->update('questions', ['isDeleted' => 1]);
    }

    // Method to update question details
    public function updateQuestionDetails($questionID, $editedData)
    {
        // Update quiz details
        $quizData = array(
            'quizName' => $editedData['quizName'],
            'quizDescription' => $editedData['quizDescription']
        );
        $this->db->where('quizID', $questionID);
        $this->db->update('quizdetails', $quizData);

        // Update question details
        $questionData = array(
            'questionText' => $editedData['questionText'][0], // Assuming you're updating only one question at a time
            'correctAnswer' => $editedData['correctAnswer'][0] // Assuming you're updating only one question at a time
        );
        $this->db->where('questionID', $questionID);
        $this->db->update('questions', $questionData);

        // Update options details
        $optionsData = array(
            'option1' => $editedData['option1'][0], // Assuming you're updating only one question at a time
            'option2' => $editedData['option2'][0], // Assuming you're updating only one question at a time
            'option3' => $editedData['option3'][0], // Assuming you're updating only one question at a time
            'option4' => $editedData['option4'][0]  // Assuming you're updating only one question at a time
        );
        $this->db->where('questionID', $questionID);
        $this->db->update('options', $optionsData);
    }


    public function get_question_details($questionID)
    {
        $this->db->select('quizdetails.quizName, quizdetails.quizDescription, questions.questionID, questions.questionText, questions.correctAnswer, options.option1, options.option2, options.option3, options.option4');
        $this->db->from('quizdetails');
        $this->db->join('questions', 'questions.quizID = quizdetails.quizID');
        $this->db->join('options', 'options.questionID = questions.questionID');
        $this->db->where('questions.isDeleted', 0); // Only fetch non-deleted questions
        $this->db->where('questions.questionID', $questionID); // Filter by questionID
        $query = $this->db->get();

        return $query->row_array(); // Assuming you expect only one row
    }
}
