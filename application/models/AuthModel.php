<?php
class AuthModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        // Load the database library
        $this->load->database();
    }

    // Method to register a new user
    public function register_user()
    {
        // Retrieve password and confirmation password from POST data
        $password = $this->input->post('password');
        $con_password = $this->input->post('con_password');

        // Check if password matches confirmation password
        if ($password != $con_password) {
            // Set flashdata and redirect to registration page if passwords don't match
            $this->session->set_flashdata('wrong', 'The password does not match the confirmation!');
            redirect('Auth/register');
        } else {
            // Insert user data into database
            $data = array(
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "password" => $password
            );

            $this->db->insert('users', $data);
            // Set flashdata and redirect to login page after successful registration
            $this->session->set_flashdata('suc', 'You are registered. Please log in.');
            redirect('Auth/login');
        }
    }

    // Method to authenticate and login a user
    public function login_user()
    {
        // Retrieve email and password from POST data
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Query database for user with provided email and password
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        $user = $query->row(); // Get the user data

        // If user exists, set session data and redirect to main page
        if ($user) {
            $this->session->set_userdata('userID', $user->userID);
            $this->session->set_userdata('user_name', $user->username);
            $this->session->set_flashdata('suc', 'You are logged in as ' . $user->username);
            redirect('Auth/main');
        } else { // If user does not exist, set flashdata and redirect to login page
            $this->session->set_flashdata('warning', 'Incorrect Authentication!!!');
            redirect('Auth/login');
        }
    }

    // Method to get user details by ID
    public function get_user_by_id($userID)
    {
        $this->db->where('userID', $userID);
        $query = $this->db->get('users');
        return $query->row(); // Return the user data
    }
}
