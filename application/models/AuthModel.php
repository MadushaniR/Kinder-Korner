<?php
class AuthModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function register_user()
    {

        $password = $this->input->post('password');
        $con_password = $this->input->post('con_password');


        if ($password != $con_password) {
            $this->session->set_flashdata('wrong', 'The password not equal with confirmation!');
            redirect('Auth/register');
        } else {
            $data = array(
                "username" => $this->input->post('username'),
                "email" => $this->input->post('email'),
                "password" => $password
            );

            $this->db->insert('users', $data);
            $this->session->set_flashdata('suc', 'You are registered please login');
            redirect('Auth/');
        }
    }
    
    public function login_user()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->db->where('email', $email);
        $this->db->where('password', $password);
        $query = $this->db->get('users');
        $user = $query->row(); // Get the user data

        if ($user) {
            $this->session->set_userdata('userID', $user->userID);
            $this->session->set_userdata('user_name', $user->username);
            $this->session->set_flashdata('suc', 'You are logged in as ' . $user->username);
            redirect('Auth/main');
        } else {
            $this->session->set_flashdata('warning', 'Incorrect Authentication!!!');
            redirect('Auth/');
        }
    }

    public function get_user_by_id($userID)
    {
        $this->db->where('userID', $userID);
        $query = $this->db->get('users');
        return $query->row(); // Return the user data
    }
}
