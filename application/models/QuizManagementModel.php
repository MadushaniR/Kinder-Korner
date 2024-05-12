<?php
defined('BASEPATH') or exit('No direct script access allowed');

class QuizManagementModel extends CI_Model
{
    // Method to logically delete a question
    public function deleteQuestion($questionID)
    {
        // Update isDeleted flag instead of deleting the question
        $this->db->set('isDeleted', 1);
        $this->db->where('questionID', $questionID);
        $this->db->update('questions');

        // Get quizID of the deleted question
        $quizID = $this->db->select('quizID')->from('questions')->where('questionID', $questionID)->get()->row()->quizID;
        
        // Check if there are remaining undeleted questions in the same quiz
        $remainingQuestions = $this->db->where('quizID', $quizID)->where('isDeleted', 0)->get('questions')->num_rows();
        
        // If there are no remaining questions, delete the quiz details as well
        if ($remainingQuestions == 0) {
            $this->db->where('quizID', $quizID);
            $this->db->delete('quizdetails');
        }
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
            'questionText' => $editedData['question'],
            'correctAnswer' => $editedData['correctAnswer']
        );
        $this->db->where('questionID', $questionID);
        $this->db->update('questions', $questionData);

        // Update options details
        $optionsData = array(
            'option1' => $editedData['choice1'],
            'option2' => $editedData['choice2'],
            'option3' => $editedData['choice3'],
            'option4' => $editedData['choice4']
        );
        $this->db->where('questionID', $questionID);
        $this->db->update('options', $optionsData);
    }
}
