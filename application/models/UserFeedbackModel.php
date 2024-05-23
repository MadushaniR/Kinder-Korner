<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserFeedbackModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Method to update user feedback for a quiz
    public function updateFeedback($userID, $quizID, $action)
    {
        // Check if the user already has feedback for the quiz
        $existingFeedback = $this->db
            ->where('userID', $userID)
            ->where('quizID', $quizID)
            ->get('feedback')
            ->row();

        // If the user already has feedback, allow them to change it
        if ($existingFeedback) {
            $data = array(
                'isLike' => ($action == 'like') ? TRUE : FALSE,
                'isDislike' => ($action == 'dislike') ? TRUE : FALSE,
            );

            $this->db
                ->where('userID', $userID)
                ->where('quizID', $quizID)
                ->update('feedback', $data);
        } else {
            // If no existing feedback, proceed to update
            $data = array(
                'userID' => $userID,
                'quizID' => $quizID,
                'isLike' => ($action == 'like') ? TRUE : FALSE,
                'isDislike' => ($action == 'dislike') ? TRUE : FALSE,
            );

            $this->db->insert('feedback', $data);
        }

        // Update total likes and dislikes for the quiz in quizdetails table
        $this->updateQuizDetails($quizID);

        // Return updated likes and dislikes count
        return $this->getLikesDislikesCount($quizID);
    }

    // Method to update quiz details with total likes and dislikes
    public function updateQuizDetails($quizID)
    {
        // Calculate total likes and dislikes for the quiz
        $totalLikesDislikes = $this->getLikesDislikesCount($quizID);

        // Update quizdetails table with the calculated values
        $this->db
            ->where('quizID', $quizID)
            ->update('quizdetails', $totalLikesDislikes);
    }

    // Method to get total likes and dislikes count for a quiz
    public function getLikesDislikesCount($quizID)
    {
        $this->db->select('SUM(isLike) as totalLikes, SUM(isDislike) as totalDislikes');
        $this->db->where('quizID', $quizID);
        $query = $this->db->get('feedback');

        return $query->row_array();
    }
}
