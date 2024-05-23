<?php
class AuthModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database(); 
        $this->load->library('session'); 
    }

    // register a new user
    public function register_user()
    {
        // get the password and confirmation password from POST data
        $password = $this->input->post('password');
        $con_password = $this->input->post('con_password');

        // check if the password matches 
        if ($password != $con_password) {
            return 'The password does not match the confirmation!';
        } else {
            // Prepare user data for insertion
            $data = array(
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "password" => $password
            );

            // Insert user data into the 'users' table
            $this->db->insert('users', $data);
            $this->load->view('Auth/login');
            return 'You are registered. Please log in.';
        }
    }

    // Method to authenticate and login a user
    public function login_user($email, $password)
    {
        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        $user = $query->row(); // Get the user data

        // If user exists, set session data and return success message
        if ($user) {
            $this->session->set_userdata('userID', $user->userID);
            $this->session->set_userdata('user_name', $user->username);
            return 'Login successful';
        } else { 
            return 'Incorrect email or password';
        }
    }

    // Method to get user details by user ID
    public function get_user_by_id($userID)
    {
        $this->db->where('userID', $userID);
        $query = $this->db->get('users');
        return $query->row();
    }
}
