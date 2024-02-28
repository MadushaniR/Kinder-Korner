<?php
defined('BASEPATH') or exit('No direct script access allowed');
class QuizManagementModel extends CI_Model
{
 
    public function deleteQuestion($questionID)
    {
        // Get the quizID associated with the question
        $quizID = $this->db->select('quizID')->from('questions')->where('questionID', $questionID)->get()->row()->quizID;

        // Delete options first
        $this->db->where('questionID', $questionID);
        $this->db->delete('options');

        // Now, delete the question
        $this->db->where('questionID', $questionID);
        $this->db->delete('questions');

        // Check if there are no more questions for the same quiz
        $remainingQuestions = $this->db->where('quizID', $quizID)->get('questions')->num_rows();

        // If no more questions, delete the quizdetails row
        if ($remainingQuestions == 0) {
            $this->db->where('quizID', $quizID);
            $this->db->delete('quizdetails');
        }
    }

 

    public function updateQuestionDetails($questionID, $editedData)
    {
        // Update quiz details
        $quizData = array(
            'quizName' => $editedData['quizName'],
            'quizDescription' => $editedData['quizDescription']
        );
        $this->db->where('quizID', $questionID);  // Use 'quizID' instead of 'questionID'
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
