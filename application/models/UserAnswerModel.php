<?php
defined('BASEPATH') or exit('No direct script access allowed');
class UserAnswerModel extends CI_Model
{
    // public function storeUserAnswers($userAnswers)
    // {
    //     // Iterate through user answers and update the database
    //     foreach ($userAnswers as $answer) {
    //         $data = array(
    //             'userID' => $answer['userID'],
    //             'quizID' => $answer['quizID'],
    //             'questionID' => $answer['questionID'],
    //             'selectedOption' => $answer['selectedOption'],
    //             'quizNumber' => $this->getQuizNumber($answer['quizID']), // Added function to get quizNumber
    //         );

    //         $this->db->insert('useranswer', $data);
    //     }

    //     // Check for errors
    //     $error = $this->db->error();

    //     if ($error['code'] !== 0) {
    //         // Handle the error (e.g., log it, display an error message)
    //         echo 'Database Error: ' . $error['message'];
    //         // Print the last query for debugging purposes
    //         echo 'Last Query: ' . $this->db->last_query();
    //     } else {
    //         // Successful insertion
    //         echo 'User answers stored successfully!';
    //     }
    // }

    // // // Function to get quizNumber based on quizID
    // private function getQuizNumber($quizID)
    // {
    //     return $this->db->select('quizNumber')->from('quizdetails')->where('quizID', $quizID)->get()->row()->quizNumber;
    // }

    // public function getUserAnswers($userID, $quizID)
    // {
    //     $this->db->select('questionID, selectedOption');
    //     $this->db->from('useranswer');
    //     $this->db->where('userID', $userID);
    //     $this->db->where('quizID', $quizID);
    //     $query = $this->db->get();
    //     return $query->result();
    // }
}
