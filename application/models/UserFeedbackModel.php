<?php
defined('BASEPATH') or exit('No direct script access allowed');
class UserFeedbackModel extends CI_Model
{
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
            echo "Database error: " . $db_error['code'] . ' ' . $db_error['message'];
        } else {
            // Check if the update was successful
            if ($this->db->affected_rows() > 0) {
                echo "Quiz details updated successfully!";
            } else {
                echo "No rows affected. Error updating quiz details!";
            }
        }
    }

    public function getLikesDislikesCount($quizID)
    {
        $this->db->select('SUM(isLike) as totalLikes, SUM(isDislike) as totalDislikes');
        $this->db->where('quizID', $quizID);
        $query = $this->db->get('feedback');

        return $query->row_array();
    }
}
