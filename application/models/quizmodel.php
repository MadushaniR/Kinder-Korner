<?php
defined('BASEPATH') or exit('No direct script access allowed');
class quizmodel extends CI_Model
{

    public function getQuestions($quizNumber)
    {
        $this->db->select("quizID, question, choice1, choice2, choice3, answer, quizNumber");
        $this->db->from("Quiz");
        $this->db->where("quizNumber", $quizNumber);

        $query = $this->db->get();

        return $query->result();

        $num_data_returned = $query->num_rows;

        if ($num_data_returned < 1) {
            echo "There is no data in db";
            exit();
        }
    }

    public function saveQuiz($quizTitle)
    {
        // Perform validation and save the quiz details to the 'Quiz' table
        $data = array(
            'quizTitle' => $quizTitle,
            // Add more fields as needed
        );

        $this->db->insert('quiz', $data);

        // Return the ID of the newly inserted quiz
        return $this->db->insert_id();
    }
}
